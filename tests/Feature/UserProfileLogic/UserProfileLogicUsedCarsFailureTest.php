<?php

namespace Tests\Feature\VehicleUploadUserTypes;

use App\Company;
use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserProfileLogicUsedCarsFailureTest extends TestCase
{
    /**
     * * @test
     */
    public function UCImportWithoutUploaderRoleFailureTest()
    {
        $user = User::factory(['stock_type' => 'UC'])
            ->has(Company::factory())
            ->create();

        $user->load('company');

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

        $response->assertJsonFragment([
            'message' => 'User does not have the right roles.',
        ]);

        $response->assertStatus(403);
    }


    /**
     * * @test
     */
    public function UCImportWithoutVehicleTypeFailureTest()
    {
        $user = User::factory(['stock_type' => 'UC', 'vehicle_type' => null])
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

        $response->assertJsonFragment([
            'errors' => 'User is missing VPVU information. Upload not possible',
        ]);

        $response->assertStatus(400);
    }

    /**
     * * @test
     */
    public function UCImportWithoutStockTypeFailureTest()
    {
        $user = User::factory(['stock_type' => null, 'vehicle_type' => ['Passenger', 'LCV']])
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

        $response->assertJsonFragment([
            'errors' => 'User is missing Stock Type information. Upload not possible',
        ]);

        $response->assertStatus(400);
    }

    /**
     * * @test
     */
    public function UCImportWithoutCompanyFailureTest()
    {
        $user = User::factory(['stock_type' => 'UC', 'company_id' => null, 'vehicle_type' => ['Passenger', 'LCV']])
            ->create();

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

        $response->assertJsonFragment([
            'errors' => 'User is missing company information. Upload not possible',
        ]);

        $response->assertStatus(400);
    }
}
