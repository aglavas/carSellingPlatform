<?php

namespace App\Service;

use App\Exceptions\AutoSphereException;
use Illuminate\Support\Facades\Http;

class AutosphereService
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $endpointUrl;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $apiUser;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $apiPassword;

    /**
     * AutosphereService constructor.
     * @throws AutoSphereException
     */
    public function __construct()
    {
        $this->apiUser = config('carmarket.autosphere.user');
        $this->apiPassword = config('carmarket.autosphere.password');
        $this->endpointUrl = config('carmarket.autosphere.endpoint_url');

        if (!$this->apiUser || !$this->apiPassword || !$this->endpointUrl) {
            throw new AutoSphereException('Missing credentials for car bidding connection. Please set client id and api token');
        }
    }

    /**
     * Fetch AutoSphere vehicles
     *
     * @return mixed
     * @throws AutoSphereException
     */
    public function fetchAutoSphereVehicles()
    {
        try {
            $response = Http::withHeaders([
                'php-auth-user' => $this->apiUser,
                'php-auth-pw' => $this->apiPassword
            ])->post($this->endpointUrl);
        } catch (\Exception $exception) {
            throw new AutoSphereException($exception->getMessage());
        }

        if (!$response->successful()) {
            throw new AutoSphereException('Request failed.' . $response->body());
        }

        $responseArray = json_decode($response->body(), true);

        return $responseArray;
    }
}
