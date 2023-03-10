<?php

namespace Tests\Unit\Notification;

use App\Company;
use App\Constants\VinEventType;
use App\Events\ImportFinished;
use App\Imports\StockUsedCentralEuropeImport;
use App\Listeners\VinHistoryChange;
use App\Notification;
use App\StockListUpload;
use App\StockUsedCentralEurope;
use App\User;
use App\VinHistory;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class NotificationVinHistoryTest extends TestCase
{

    /**
     * Set up before any test
     */
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        StockListUpload::unsetEventDispatcher();

        VinHistory::truncate();

        Notification::truncate();

        StockUsedCentralEurope::truncate();
    }

    /**
     * Test new vin upload notification success
     *
     * @return bool
     */
    public function testNewVinNotificationSuccess()
    {
        $vinArray = NotificationTestData::returnTestData();

        App::instance('vin_candidates', $vinArray);

        $vinHistoryChange = new VinHistoryChange(new VinHistory(), new StockUsedCentralEurope());

        $user = factory(User::class)->create();

        $user->load('company');

        $stockListUpload = factory(StockListUpload::class)->create(['uploader_id' => $user->id]);

        $importFinishedEvent = new ImportFinished($user, $stockListUpload);

        $vinHistoryChange->handle($importFinishedEvent);

        foreach ($vinArray as $vinData) {
            $this->assertDatabaseHas('vin_history', ['vin' => $vinData['vin'], 'event_type' => VinHistory::EVENT_TYPE_ADDED, 'company' => $user->company->name, 'country' => $user->country, 'user_id' => $user->id]);
        }

        $this->assertDatabaseHas('notifications', ['event_type' => Notification::UPLOAD_NEW_VIN, 'list_type' => $stockListUpload->list_type, 'country' => $user->country, 'company' => $user->company->name, 'user_id' => $user->id, 'data_count' => count($vinArray)]);

        return true;
    }

    /**
     * Test new vin upload notification success with removed duplicates
     *
     * @return void
     */
    public function testNewVinNotificationDuplicateVinSuccess()
    {
        $vinArray = NotificationTestData::returnTestDataWithDuplicates();

        App::instance('vin_candidates', $vinArray);

        $vinHistoryChange = new VinHistoryChange(new VinHistory(), new StockUsedCentralEurope());

        $user = factory(User::class)->create();

        $user->load('company');

        $stockListUpload = factory(StockListUpload::class)->create(['uploader_id' => $user->id]);

        $importFinishedEvent = new ImportFinished($user, $stockListUpload);

        $vinHistoryChange->handle($importFinishedEvent);

        $lastElement = end($vinArray);

        foreach ($vinArray as $key => $vinData) {

            if ($vinData == $lastElement) {
                continue;
            }

            $this->assertDatabaseHas('vin_history', ['vin' => $vinData['vin'], 'event_type' => VinHistory::EVENT_TYPE_ADDED, 'company' => $user->company->name, 'country' => $user->country, 'user_id' => $user->id]);
        }

        $vinArrayCount = count($vinArray);

        $vinArrayCountWithoutDuplicates = $vinArrayCount - 1;

        $this->assertDatabaseHas('notifications', ['event_type' => Notification::UPLOAD_NEW_VIN, 'list_type' => $stockListUpload->list_type, 'country' => $user->country, 'company' => $user->company->name, 'user_id' => $user->id, 'data_count' => $vinArrayCountWithoutDuplicates]);
    }

    /**
     * Test new vin upload notification success with removed duplicates
     *
     * @return void
     */
    public function testUpdateUsedCarUploadSuccess()
    {
        $user = factory(User::class)->create();

        $user->load('company');

        $vinAddedArray = NotificationTestData::returnTestData();

        $request = [];

        foreach ($vinAddedArray as $key => $vinData) {
            $jsonAttributes = json_encode($vinData['attributes']);

            array_push($request, [
                'vin' => $vinData['vin'],
                'event_type' => VinEventType::ADDED,
                'company' => $user->company->name,
                'country' => $user->country,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'attributes' => $jsonAttributes,
                'hashed_attributes' => $vinData['hashed_attributes'],
            ]);

            factory(StockUsedCentralEurope::class)->create(['vin' => $vinData['vin'], 'company' => $user->company->name, 'country' => strtolower($user->country)]);
        }

        VinHistory::insert($request);

        $vinArray = NotificationTestData::returnTestDataWithUpdatesForStockUsedCars();

        App::instance('vin_candidates', $vinArray);

        $vinHistoryChange = new VinHistoryChange(new VinHistory(), new StockUsedCentralEurope());

        $stockListUpload = factory(StockListUpload::class)->create(['uploader_id' => $user->id, 'list_type' => StockUsedCentralEuropeImport::class, 'country' => $user->country]);

        $importFinishedEvent = new ImportFinished($user, $stockListUpload);

        $vinHistoryChange->handle($importFinishedEvent);

        $updatedVinArray = [$vinArray[0], $vinArray[1], $vinArray[2]];

        foreach ($updatedVinArray as $key => $vinData) {
            $this->assertDatabaseHas('vin_history', ['vin' => $vinData['vin'], 'event_type' => VinHistory::EVENT_TYPE_ADDED, 'company' => $user->company->name, 'country' => $user->country, 'user_id' => $user->id]);
        }

        $vinArrayCount = count($updatedVinArray);

        $this->assertDatabaseHas('notifications', ['event_type' => Notification::UPDATE_EXISTING_VIN, 'list_type' => $stockListUpload->list_type, 'country' => $user->country, 'company' => $user->company->name, 'user_id' => $user->id, 'data_count' => $vinArrayCount]);
    }

    /**
     * Test new vin upload notification success with removed duplicates
     *
     * @return void
     */
    public function testVinHistoryDeletedVinCodes()
    {
        $company = factory(Company::class)->create(['name' => 'Avto Triglav d.o.o.']);

        $user = factory(User::class)->create(['country' => 'SI', 'company_id' => $company->id]);

        $user->load('company');

        $vinAddedArray = NotificationTestData::returnTestData();

        $request = [];

        foreach ($vinAddedArray as $key => $vinData) {
            $jsonAttributes = json_encode($vinData['attributes']);

            array_push($request, [
                'vin' => $vinData['vin'],
                'event_type' => VinEventType::ADDED,
                'company' => $user->company->name,
                'country' => $user->country,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'attributes' => $jsonAttributes,
                'hashed_attributes' => $vinData['hashed_attributes'],
            ]);
        }

        VinHistory::insert($request);

        $vinDeletedArray = NotificationTestData::returnTestDataWithDeletedVinCodes();

        foreach ($vinDeletedArray as $key => $vinData) {
            factory(StockUsedCentralEurope::class)->create(['vin' => $vinData['vin'], 'company' => $user->company->name, 'country' => strtolower($user->country)]);
        }


        $deletedVinCodes = [
            [
                'vin' => 'VR1J45GGUKY183991',
                'country' => 'SI',
                'company' => 'Avto Triglav d.o.o.',
                'attributes' =>
                    [
                        'b2b_price_ex_vat' => 30850,
                        'price_in_euro' => 30850,
                    ],
                'hashed_attributes' => 'b57af2ac2ba43d29cf73ff86d95a3623',
            ],
            [
                'vin' => 'VR3F35GGRKY041569',
                'country' => 'SI',
                'company' => 'Avto Triglav d.o.o.',
                'attributes' =>
                    [
                        'b2b_price_ex_vat' => 26843,
                        'price_in_euro' => 26843,
                    ],
                'hashed_attributes' => '7e6055d1b80a24b867730f8a39b04794',
            ]
        ];

        $vinArray = NotificationTestData::returnTestDataWithDeletedVinCodes();

        App::instance('vin_candidates', $vinArray);

        $vinHistoryChange = new VinHistoryChange(new VinHistory(), new StockUsedCentralEurope());

        $stockListUpload = factory(StockListUpload::class)->create(['uploader_id' => $user->id, 'list_type' => StockUsedCentralEuropeImport::class, 'country' => $user->country]);

        $importFinishedEvent = new ImportFinished($user, $stockListUpload);

        $vinHistoryChange->handle($importFinishedEvent);

        foreach ($deletedVinCodes as $key => $vinData) {
            $this->assertDatabaseHas('vin_history', ['vin' => $vinData['vin'], 'event_type' => VinHistory::EVENT_TYPE_DELETED, 'company' => $vinData['company'], 'country' => $vinData['country']]);
        }
    }

    /**
     * Test new vin upload notification, from 2 different users
     *
     * @return bool
     */
    public function testNewVinNotificationMultipleUsers()
    {
        $firstUser = factory(User::class)->create(['country' => 'SK']);

        $firstUser->load('company');

        $secondUser = factory(User::class)->create(['country' => 'SI']);

        $secondUser->load('company');

        $firstVinArray = NotificationTestData::returnTestDataCustomCompanyCountry($firstUser->country, $firstUser->company->name);

        $secondVinArray = NotificationTestData::returnTestDataCustomCompanyCountry($secondUser->country, $secondUser->company->name);

        App::instance('vin_candidates', $firstVinArray);

        $vinHistoryChange = new VinHistoryChange(new VinHistory(), new StockUsedCentralEurope());

        $stockListUpload = factory(StockListUpload::class)->create(['uploader_id' => $firstUser->id]);

        $importFinishedEvent = new ImportFinished($firstUser, $stockListUpload);

        $vinHistoryChange->handle($importFinishedEvent);

        foreach ($firstVinArray as $vinData) {
            $this->assertDatabaseHas('vin_history', ['vin' => $vinData['vin'], 'event_type' => VinHistory::EVENT_TYPE_ADDED, 'company' => $firstUser->company->name, 'country' => $firstUser->country, 'user_id' => $firstUser->id]);
        }

        $this->assertDatabaseHas('notifications', ['event_type' => Notification::UPLOAD_NEW_VIN, 'list_type' => $stockListUpload->list_type, 'country' => $firstUser->country, 'company' => $firstUser->company->name, 'user_id' => $firstUser->id, 'data_count' => count($firstVinArray)]);

        App::instance('vin_candidates', $secondVinArray);

        $stockListUpload = factory(StockListUpload::class)->create(['uploader_id' => $secondUser->id]);

        $importFinishedEvent = new ImportFinished($secondUser, $stockListUpload);

        $vinHistoryChange->handle($importFinishedEvent);

        foreach ($firstVinArray as $vinData) {
            $this->assertDatabaseHas('vin_history', ['vin' => $vinData['vin'], 'event_type' => VinHistory::EVENT_TYPE_ADDED, 'company' => $secondUser->company->name, 'country' => $secondUser->country, 'user_id' => $secondUser->id]);
        }

        $this->assertDatabaseHas('notifications', ['event_type' => Notification::UPLOAD_NEW_VIN, 'list_type' => $stockListUpload->list_type, 'country' => $secondUser->country, 'company' => $secondUser->company->name, 'user_id' => $secondUser->id, 'data_count' => count($secondVinArray)]);
    }
}
