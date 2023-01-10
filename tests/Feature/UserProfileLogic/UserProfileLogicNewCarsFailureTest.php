<?php

namespace Tests\Feature\VehicleUploadUserTypes;

use App\Company;
use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserProfileLogicNewCarsFailureTest extends TestCase
{
    /**
     * * @test
     */
    public function NCImportWithoutUploaderRoleFailureTest()
    {
        $user = User::factory(['stock_type' => 'NC'])
            ->has(Company::factory())
            ->create();

        $user->load('company');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid_nc.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid_nc.xlsx', null, null, true);

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
    public function NCImportWithoutVehicleTypeFailureTest()
    {
        $user = User::factory(['stock_type' => 'NC', 'vehicle_type' => null])
            ->has(Company::factory())
            ->create();

        $user->load('company');

        $user->assignRole('Uploader');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid_nc.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid_nc.xlsx', null, null, true);

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
    public function NCImportWithoutStockTypeFailureTest()
    {
        $user = User::factory(['stock_type' => null, 'vehicle_type' => ['Passenger', 'LCV']])
            ->has(Company::factory())
            ->create();

        $user->load('company');

        $user->assignRole('Uploader');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid_nc.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid_nc.xlsx', null, null, true);

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
    public function NCImportWithoutCompanyFailureTest()
    {
        $user = User::factory(['stock_type' => 'NC', 'company_id' => null, 'vehicle_type' => ['Passenger', 'LCV']])
            ->create();

        $user->assignRole('Uploader');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid_nc.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid_nc.xlsx', null, null, true);

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
    public function NCImportWithoutBrandFailureTest()
    {
        $user = User::factory(['stock_type' => 'NC', 'vehicle_type' => ['Passenger', 'LCV']])
            ->create();

        $user->assignRole('Uploader');

        $token = $user->api_token;

        $filePath = storage_path("test-lists") . "/unified_list_valid_nc.xlsx";

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile ($filePath, 'unified_list_valid_nc.xlsx', null, null, true);

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
