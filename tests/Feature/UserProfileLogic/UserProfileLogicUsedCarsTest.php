<?php

namespace Tests\Feature\VehicleUploadUserTypes;

use App\Company;
use App\StockVehicle;
use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserProfileLogicUsedCarsTest extends TestCase
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var Company
     */
    public $company;

    /**
     * @var string
     */
    public $country;

    /**
     * When running tests comment out file validation rule in VehicleImportRequest
     */
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        StockVehicle::truncate();

        $this->user = User::factory(['stock_type' => 'UC', 'vehicle_type' => ['Truck']])
            ->has(Company::factory())
            ->create();

        $this->user->load('company');

        $company = $this->user->company;
        $country = $this->user->getCountry();

        $vehicleCollection = StockVehicle::withoutEvents(function () use ($country, $company) {
            return StockVehicle::factory([
                'company_id' => $company->id,
                'company' => $company->name,
                'country' => $country,
                'condition_type' => 'used'
            ])->count(5)->create();
        });

        $this->company = $company;
        $this->country = $country;
    }

    /**
     * * @test
     */
    public function UCImportSuccessTest()
    {
        $user = User::factory(['stock_type' => 'UC'])
            ->has(Company::factory())
            ->create();

        $user->load('company');

        $user->assignRole('Uploader');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid.xlsx', null, null, true);

        $finalFile = UploadedFile::createFromBase($file);

        $rawBody['file'] = $finalFile;

        $response = $this->actingAs($user)
            ->post("/api/v1/vehicle/import", $rawBody, [
                "Accept" => "application/json",
                "Content-Type" => "multipart/form-data",
                "Authorization" => "Bearer $token"
            ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'status' => 'success',
            'message' => 'Upload successful.',
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA7K310407F25511'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA7K310307F19622'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBS1J51080VA11733'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA6Y310307D40844'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WCS1J51080VA11733'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WDA6Y310307D40844'
        ]);

        $rawBody['file'] = $finalFile;

        $response = $this->actingAs($user)
            ->post("/api/v1/vehicle/import", $rawBody, [
                "Accept" => "application/json",
                "Content-Type" => "multipart/form-data",
                "Authorization" => "Bearer $token"
            ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'status' => 'success',
            'message' => 'Upload successful.',
        ]);

        $this->assertDatabaseCount('stock_vehicles', 11);
    }

    /**
     * * @test
     */
    public function UCImportUsedNewSuccessTest()
    {
        $user = User::factory(['stock_type' => 'UC'])
            ->has(Company::factory())
            ->create();

        $user->load('company');

        $user->assignRole('Uploader');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid_uc_nc.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid_uc_nc.xlsx', null, null, true);

        $finalFile = UploadedFile::createFromBase($file);

        $rawBody['file'] = $finalFile;

        $response = $this->actingAs($user)
            ->post("/api/v1/vehicle/import", $rawBody, [
                "Accept" => "application/json",
                "Content-Type" => "multipart/form-data",
                "Authorization" => "Bearer $token"
            ]);

        $responseData = $response->getOriginalContent();

        $validationErrors = $responseData['errors'];

        $validationErrorsArray = $this->parseValidationErrorArray($validationErrors);

        $response->assertJsonFragment([
            'status' => 'partial import',
            'message' => 'Upload partially successful. There were errors during the upload.',
        ]);

        $validationErrorsArrayCount = count($validationErrorsArray);

        $this->assertEquals(3, $validationErrorsArrayCount);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA7K310407F25511'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA7K310307F19622'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBS1J51080VA11733'
        ]);

        $this->assertDatabaseCount('stock_vehicles', 8);
    }

    /**
     * * @test
     */
    public function UCImportUserOverWriteOtherUCUserSuccess()
    {
        $user = User::factory(['stock_type' => 'UC', 'company_id' => $this->company->id, 'country' => $this->country, 'vehicle_type' => ['Passenger', 'LCV']])
                ->create();

        $user->load('company');

        $user->assignRole('Uploader');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid.xlsx', null, null, true);

        $finalFile = UploadedFile::createFromBase($file);

        $rawBody['file'] = $finalFile;

        $response = $this->actingAs($user)
            ->post("/api/v1/vehicle/import", $rawBody, [
                "Accept" => "application/json",
                "Content-Type" => "multipart/form-data",
                "Authorization" => "Bearer $token"
            ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'status' => 'success',
            'message' => 'Upload successful.',
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA7K310407F25511'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA7K310307F19622'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBS1J51080VA11733'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WBA6Y310307D40844'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WCS1J51080VA11733'
        ]);

        $this->assertDatabaseHas('stock_vehicles', [
            'manufacturer_id' => 'WDA6Y310307D40844'
        ]);

        $this->assertDatabaseCount('stock_vehicles', 6);
    }
}