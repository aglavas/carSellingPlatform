<?php

namespace Tests\Feature;

use App\Company;
use App\StockVehicle;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class VehicleUploadFailureTest extends TestCase
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
    public $token;

    /**
     * When running tests comment out file validation rule in VehicleImportRequest
     */
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        StockVehicle::truncate();

        $user = User::factory(['stock_type' => 'UC'])
        ->has(Company::factory())
        ->create();

        $user->load('company');

        $this->user = $user;
        $this->company = $this->user->company;
        $this->token = $user->api_token;

        $otherCompanyId = $this->company->id + 1;
        $otherCompanyName = $this->company->name . 'XXX';
        $otherCountry = $user->country . 'X';

        $vehicle = StockVehicle::withoutEvents(function () use ($otherCompanyId, $otherCompanyName, $otherCountry) {
            return StockVehicle::factory()->create([
                'manufacturer_id' => 'WBA7K310407F25511',
                'company_id' => $otherCompanyId,
                'company' => $otherCompanyName,
                'country' => $otherCountry,
            ]);
        });
    }

    /**
     * * @test
     */
    public function importVehicleListWithExistingManufacturerIdTest()
    {
        $this->user->assignRole('Uploader');

        $filePath = storage_path("test-lists") . "/unified_list_valid.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid.xlsx', null, null, true);

        $finalFile = UploadedFile::createFromBase($file);

        $rawBody['file'] = $finalFile;

        /** @var TestResponse $response */
        $response = $this->actingAs($this->user)
            ->post("/api/v1/vehicle/import", $rawBody, [
                "Accept" => "application/json",
                "Content-Type" => "multipart/form-data",
                "Authorization" => "Bearer $this->token"
            ]);

        $response->assertStatus(201);

        $responseData = $response->getOriginalContent();

        $validationErrors = $responseData['errors'];

        $validationErrorsArray = $this->parseValidationErrorArray($validationErrors);

        $response->assertJsonFragment([
            'status' => 'partial import',
            'message' => 'Upload partially successful. There were errors during the upload.',
        ]);

        $this->assertEquals([
            1 => "The manufacturer_id has already been taken."
        ], $validationErrorsArray);

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