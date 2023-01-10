<?php

namespace App\Service\CarBidding;

use App\CarBiddingCredentials;
use App\CarBiddingPrices;
use App\Exceptions\CarBiddingException;
use App\StockVehicle;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BiddingService
{
    /**
     * @var integer
     */
    public $clientId;

    /**
     * @var string
     */
    public $apiToken;

    /**
     * @var string
     */
    public $endpointUrl;

    /**
     * @var BiddingConverter
     */
    public $biddingConverter;

    /**
     * @var StockVehicle
     */
    public $stockVehicle;

    /**
     * @var CarBiddingCredentials
     */
    public $biddingCredentials;

    /**
     * @var CarBiddingPrices
     */
    public $biddingPrices;

    /**
     * @var User
     */
    public $user;

    /**
     * @var array
     */
    public $responseColumns = [
        'countryID',
        'priceType',
        'fuelType',
        'netherlandsFuel',
        'importEU',
        'euroClass',
        'euroClassPaid',
        'coc',
        'carType',
        'newUsed',
        'sellPrice',
        'carWeight',
        'cm3',
        'engineSize',
        'kwhp',
        'carValueNew',
        'co2',
        'prodDate',
    ];

    /**
     *
     * BiddingService constructor.
     * @param BiddingConverter $biddingConverter
     * @param StockVehicle $stockVehicle
     * @param CarBiddingCredentials $biddingCredentials
     * @param CarBiddingPrices $biddingPrices
     * @param User $user
     * @throws CarBiddingException
     */
    public function __construct(
        BiddingConverter $biddingConverter,
        StockVehicle $stockVehicle,
        CarBiddingCredentials $biddingCredentials,
        CarBiddingPrices $biddingPrices,
        User $user
    )
    {
        $this->clientId = config('carmarket.bidding.client_id');
        $this->apiToken = config('carmarket.bidding.api_token');
        $this->endpointUrl = config('carmarket.bidding.endpoint_url');
        $this->biddingConverter = $biddingConverter;
        $this->stockVehicle = $stockVehicle;
        $this->biddingCredentials = $biddingCredentials;
        $this->biddingPrices = $biddingPrices;
        $this->user = $user;

        if (!$this->clientId || !$this->apiToken || !$this->endpointUrl) {
            throw new CarBiddingException('Missing credentials for car bidding connection. Please set client id and api token');
        }
    }

    /**
     * Send car data
     *
     * @param Collection $vehicleCollection
     * @return bool
     * @throws \Exception
     */
    public function sendCarData(Collection $vehicleCollection)
    {
        DB::beginTransaction();

        try {
            list($sessionToken, $hashedClientId) = $this->getSessionToken();

            $this->storeCredentials($sessionToken, $hashedClientId);

            $biddingVehicleData = $this->sendVehicleData($vehicleCollection, $sessionToken);

            $this->handleVehicleData($biddingVehicleData);
        } catch (\Exception $exception) {
            DB::rollBack();

            activity('pricing_sync_error')
                ->withProperties($exception)
                ->log('General sync error.');

            throw $exception;
        }

        DB::commit();

        return true;
    }

    /**
     * Receive car data
     *
     * @param Request $request
     * @param $apiToken
     * @return bool
     * @throws AuthenticationException
     */
    public function receiveCarData(Request $request, $apiToken)
    {
         $this->checkCredentials($apiToken);

         $this->checkSentKey($request, $apiToken);

         if ($request->has('carprices')) {
             DB::beginTransaction();

             try {
                 $carPrices = $request->input('carprices');

                 $carPrices = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $carPrices), true );

                 if (isset($carPrices[0]['carID'])) {
                     $carId = $carPrices[0]['carID'];
                 } else {
                     throw new \Exception("Car id is missing from hook.");
                 }

                 $stockVehicle = $this->getVehicle($carId);

                 if (!$stockVehicle) {
                     return true;
                 }

                 $manufacturerId = $stockVehicle->manufacturer_id;

                 foreach ($carPrices as $price) {
                     $countryFrom = $this->biddingConverter->convertCountryHook($price['countryFrom']);
                     $countryTo = $this->biddingConverter->convertCountryHook($price['countryTo']);

                     if ($carId != $price['carID']) {
                         throw new \Exception("Car ids are different. Id: " . $price['carID']);
                     }

                     $this->biddingPrices->updateOrCreate([
                         'manufacturer_id' => $manufacturerId,
                         'country_from' => $countryFrom,
                         'country_to' => $countryTo,
                     ], [
                         'price_id' => $price['car_priceID'],
                         'client_id' => $price['clientID'],
                         'price' => $price['price'],
                         'bpm_outcome' => $price['BPMOutcome'],
                         'currency' => $price['currency'],
                         'session_token_id' => $price['session_tokenID'],
                         'status' => $price['status'],
                     ]);
                 }

                 $stockVehicle->addToSettings([
                     'bidding_status' => StockVehicle::STATUS_SYNC_COMPLETED,
                 ]);
             } catch (\Exception $exception) {
                 DB::rollBack();

                 activity('pricing_hook_sync_error')
                     ->withProperties($exception)
                     ->log('Hook sync error.');

                 throw $exception;
             }

             DB::commit();
         }

         return true;
    }

    /**
     * Convert vehicles numerical id to manufacturer id
     *
     * @param $id
     * @return bool|StockVehicle
     */
    private function getVehicle($id)
    {
        $stockVehicle = $this->stockVehicle->where('id', $id)->first();

        if ($stockVehicle) {
            return $stockVehicle;
        }

        return false;
    }

    /**
     * @Deprecated
     *
     * @param Request $request
     * @param $apiToken
     * @return bool
     */
    private function checkSentKey(Request $request, $apiToken)
    {
        $timeKey = $this->getTimeParam();

        $clientId = '';

        if ($request->has('clientID')) {
            $clientId = base64_decode($request->input('clientID'));
        }

        $hashed = hash('sha512', $timeKey.$clientId);

        $key = $request->input('key', '');

        activity('pricing_additional_check')
            ->withProperties([
                'hashed' => $hashed,
                'key' => $key,
            ])
            ->log('Additional check.');

        return true;
    }

    /**
     * Check credentials
     *
     * @param $apiToken
     * @return bool
     * @throws AuthenticationException
     */
    private function checkCredentials($apiToken)
    {
        $user = $this->user->where(['api_token' => $apiToken])->first();

        $authenticatedUser = Auth::user();

        if ($user->id != $authenticatedUser->id) {
            activity('pricing_receive_auth_error')
                ->withProperties([
                    'user_id' => $user->id,
                    'auth_user_id' => $authenticatedUser->id,
                ])
                ->log('Auth error on receiving bidding data.');

            throw new AuthenticationException();
        }

        return true;
    }

    /**
     * Store car bidding credentials
     *
     * @param string $sessionToken
     * @param string $hashedClientId
     * @return bool
     */
    private function storeCredentials(string $sessionToken, string $hashedClientId)
    {
        $this->biddingCredentials->updateOrCreate([
           'api_token' => $this->apiToken
        ], [
            'info_key' => $hashedClientId,
            'session_token' => $sessionToken,
        ]);

        return true;
    }

    /**
     * Handle vehicle data
     *
     * @param array $biddingVehicleData
     * @return bool
     */
    private function handleVehicleData(array $biddingVehicleData)
    {
        foreach ($biddingVehicleData as $vehicleId => $data) {
            /** @var StockVehicle $stockVehicle */
            $stockVehicle = $this->stockVehicle->where('id', $vehicleId)->first();

            if (!$stockVehicle) {
                continue;
            }

            $error = null;

            $responseStatusData = $data['status'][$vehicleId];

            foreach ($this->responseColumns as $column) {
                if ($responseStatusData[$column] != 100) {
                    $error = true;
                }
            }

            if (!$error) {
                $stockVehicle->addToSettings([
                    'bidding_status' => StockVehicle::STATUS_SYNC_SUCCESS,
                    'bidding_token_id' => $data['tokenID']
                ]);
            } else {
                activity('send_vehicle_data_validation_errors')
                    ->withProperties([
                        'manufacturer_id' => $stockVehicle->manufacturer_id,
                        'validation_errors' => $responseStatusData
                    ])
                    ->log('Validation errors in carbidding response.');
                
                $stockVehicle->addToSettings([
                    'bidding_status' => StockVehicle::STATUS_SYNC_ERROR,
                    'bidding_token_id' => $data['tokenID']
                ]);
            }
        }

        return true;
    }

    /**
     * Send vehicle data
     *
     * @param Collection $vehicleCollection
     * @param string $sessionToken
     * @return bool|mixed|string
     * @throws CarBiddingException
     */
    private function sendVehicleData(Collection $vehicleCollection, string $sessionToken)
    {
        $vehicleData = $this->biddingConverter->convert($vehicleCollection, $this->clientId);

        $requestData = ["cardata_input" => json_encode($vehicleData),"sessionToken" => $sessionToken];

        activity('pricing_data_sent')
            ->withProperties($requestData)
            ->log('Data sent for bidding.');

        $biddingVehicleData = $this->sendRequest($requestData);

        activity('pricing_data_sent_response')
            ->withProperties($biddingVehicleData)
            ->log('Response data for sent for bidding.');

        return $biddingVehicleData;
    }

    /**
     * Get session token
     *
     * @return array
     * @throws CarBiddingException
     */
    private function getSessionToken()
    {
        $key = $this->getTimeParam();

        $encryptedID = base64_encode($this->clientId);
        $hashedClientId = hash('sha512', $key.$this->clientId);
        $requestData = ["key" => $hashedClientId, "clientID" => $encryptedID];

        $sessionToken = $this->sendRequest($requestData);

        return [$sessionToken, $hashedClientId];
    }

    /**
     * Send request to car bidding
     *
     * @param array $requestPayload
     * @return bool|mixed|string
     * @throws CarBiddingException
     */
    private function sendRequest(array $requestPayload)
    {
        $session = curl_init();
        curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($session, CURLOPT_TIMEOUT, 30);
        curl_setopt($session, CURLOPT_URL, $this->endpointUrl);
        curl_setopt($session, CURLOPT_USERPWD, $this->apiToken);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($session, CURLOPT_POSTFIELDS, $requestPayload);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);

        try {
            $response = curl_exec($session);
        } catch (\Exception $exception) {
            throw new CarBiddingException($exception->getMessage());
        }

        curl_close($session);

        if ($response) {
            $response = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response), true );
        } else {
            throw new CarBiddingException('Connection problem. Response is empty.');
        }

        return $response;
    }

    /**
     * Get time param
     *
     * @return string
     */
    private function getTimeParam()
    {
        $hour = date('H');

        if ($hour >= 0 && $hour <= 2) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 2 && $hour <= 4) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 4 && $hour <= 6) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 6 && $hour <= 8) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 8 && $hour <= 10) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 10 && $hour <= 12) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 12 && $hour <= 14) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 14 && $hour <= 16) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 16 && $hour <= 18) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 18 && $hour <= 20) {
            $key = date("Ymd").$hour.'input';
        } elseif ($hour > 20 && $hour <= 22) {
            $key = date("Ymd").$hour.'input';
        } else {
            $key = date("Ymd").$hour.'input';
        }

        return $key;
    }
}
