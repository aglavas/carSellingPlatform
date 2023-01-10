<?php

namespace Tests\Feature\VehicleUploadUserTypes;

use App\Company;
use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserProfileLogicBothFailureTest extends TestCase
{
    /**
     * * @test
     */
    public function BothImportWithoutUploaderRoleFailureTest()
    {
        $user = User::factory(['stock_type' => 'both'])
            ->has(Company::factory())
            ->create();

        $user->load('company');

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

        $response->assertJsonFragment([
            'message' => 'User does not have the right roles.',
        ]);

        $response->assertStatus(403);
    }


    /**
     * * @test
     */
    public function BothImportWithoutVehicleTypeFailureTest()
    {
        $user = User::factory(['stock_type' => 'both', 'vehicle_type' => null])
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

        $response->assertJsonFragment([
            'errors' => 'User is missing VPVU information. Upload not possible',
        ]);

        $response->assertStatus(400);
    }

    /**
     * * @test
     */
    public function BothImportWithoutStockTypeFailureTest()
    {
        $user = User::factory(['stock_type' => null, 'vehicle_type' => ['Passenger', 'LCV']])
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

        $response->assertJsonFragment([
            'errors' => 'User is missing Stock Type information. Upload not possible',
        ]);

        $response->assertStatus(400);
    }

    /**
     * * @test
     */
    public function BothImportWithoutCompanyFailureTest()
    {
        $user = User::factory(['stock_type' => 'both', 'company_id' => null, 'vehicle_type' => ['Passenger', 'LCV']])
            ->create();

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

        $response->assertJsonFragment([
            'errors' => 'User is missing company information. Upload not possible',
        ]);

        $response->assertStatus(400);
    }

    /**
     * * @test
     */
    public function BothImportWithoutBrandFailureTest()
    {
        $user = User::factory(['stock_type' => 'both', 'vehicle_type' => ['Passenger', 'LCV']])
            ->create();

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

        $response->assertJsonFragment([
            'errors' => 'NC User is missing brand information. Upload not possible',
        ]);

        $response->assertStatus(400);
    }
}
