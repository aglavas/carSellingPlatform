<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BrandMappingException;
use App\Exceptions\ImportColumnMissingException;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleDestroyRequest;
use App\Http\Requests\VehicleImportRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Repositories\VehicleRepository;
use App\StockVehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Service\CarUploadService;

class VehicleController extends Controller
{
    /**
     * @OA\Info(
     *   title="Carmarket API",
     *   version="1.0.0",
     *   @OA\Contact(
     *     email="support@ticketzone.com",
     *     name="Support Team"
     *   )
     * )
     *
     * @OA\SecurityScheme(
     *  securityScheme="AuthJWT",
     *  scheme="bearer",
     *  type="apiKey",
     *  name="Authorization",
     *  in="header",
     *  bearerFormat="JWT"
     * )
     *
     *
     * @Schema(
     *      schema="ApiResponse",
     *      type="object",
     *      Description= "Response entity, response result uses this structure uniformly.",
     *     @Property(
     *         property="code",
     *         type="string",
     *         description= "response code"
     * )
     *
     */



    /**
     * @OA\Schema(
     *     schema="ValidationError",
     *         @OA\Property(
     *              property="field_key",
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="name is required field"
     *                  )
     *              )
     *         )
     * )
     */


    /**
     * Store a vehicle
     *
     * @OA\Post(
     *     summary="Store a single vehicle",
     *     path="/api/v1/vehicle",
     *     security={
     *       {"AuthJWT": {}}
     *      },
     *      @OA\RequestBody(
     *          description="Request body for vehicle store",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/VehicleStoreRequestSchema")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessMessageSchema")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     )
     * )
     *
     * @param Request $request
     * @param CarUploadService $carUploadService
     * @return JsonResponse
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function store(Request $request, CarUploadService $carUploadService)
    {
        $result = $carUploadService->startUpload($request->input(), CarUploadService::SOURCE_JSON);

        if ($result === true) {
            return $this->successMessageResponse('Upload successful.', 201);
        }

        return $this->messageResponse(
            'partial import',
            'Upload partially successful. There were errors during the upload.',
            $result,
            201
        );
    }

    /**
     * * Import a vehicle list
     *
     * @OA\Post(
     *     summary="Import vehicle list",
     *     path="/api/v1/vehicle/import",
     *     security={
     *       {"AuthJWT": {}}
     *      },
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Excel list",
     *                     property="file",
     *                     type="string", format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessMessageSchema")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     )
     * )
     *
     * @param VehicleImportRequest $request
     * @param CarUploadService $carUploadService
     * @return JsonResponse
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function import(VehicleImportRequest $request, CarUploadService $carUploadService)
    {
        $result = $carUploadService->startUpload($request, CarUploadService::SOURCE_FILE);

        if ($result === true) {
            return $this->successMessageResponse('Upload successful.', 201);
        }

        if ($result['error_code']) {
            return $this->messageResponse(
                'error',
                'Import terminated.',
                $result['status'],
                400
            );
        }

        return $this->messageResponse(
            'partial import',
            'Upload partially successful. There were errors during the upload.',
            $result['status'],
            201
        );
    }

    /**
     * * Delete a vehicle
     *
     * @OA\Delete(
     *     summary="Delete a vehicle",
     *     path="/api/v1/vehicle/{vehicle}",
     *     security={
     *       {"AuthJWT": {}}
     *      },
     *      @OA\Parameter(
     *          in="path",
     *          name="vehicle",
     *          description="Vehicle identifier",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *     @OA\Response(
     *         response="204",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessMessageSchema")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     )
     * )
     *
     * @param VehicleDestroyRequest $request
     * @param VehicleRepository $vehicleRepository
     * @param StockVehicle $vehicle
     * @return JsonResponse
     */
    public function destroy(VehicleDestroyRequest $request, VehicleRepository $vehicleRepository, StockVehicle $vehicle)
    {
        try {
            $vehicleRepository->deleteVehicle($vehicle);
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting vehicle.', 500);
        }

        return $this->successMessageResponse(
            'Vehicle deleted successfully.',
            204
        );
    }

    /**
     * Update a vehicle
     *
     * @OA\Put(
     *     summary="Update a vehicle",
     *     path="/api/v1/vehicle/{vehicle}",
     *     security={
     *       {"AuthJWT": {}}
     *      },
     *      @OA\Parameter(
     *          in="path",
     *          name="vehicle",
     *          description="Vehicle identifier",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          description="Request body for vehicle update",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/VehicleUpdateRequestSchema")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Vehicle updated response",
     *          @OA\JsonContent(
     *              required={"status, data"},
     *              @OA\Property(
     *                  property="status",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/VehicleResponseSchema"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     ),
     *    @OA\Response(
     *         response="400",
     *         description="Error with request",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="User is not authorized for this request",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     )
     * )
     *
     * @param VehicleUpdateRequest $request
     * @param VehicleRepository $vehicleRepository
     * @return JsonResponse
     */
    public function update(VehicleUpdateRequest $request, VehicleRepository $vehicleRepository, StockVehicle $vehicle)
    {
        try {
            $vehicle = $vehicleRepository->updateVehicle($vehicle, $request->input());
        } catch (\Exception $exception) {
            if ($exception instanceof BrandMappingException) {
                $message = $exception->getMessage();

                return $this->errorMessageResponse("Brand cannot be mapped. $message", 400);
            } elseif ($exception instanceof ImportColumnMissingException) {
                $message = $exception->getMessage();

                return $this->errorMessageResponse("Column is missing. $message" , 400);
            } else {
                return $this->errorMessageResponse('Error while updating product.', 500);
            }
        }

        return $this->successDataResponse(
            $vehicle,
            200
        );
    }

    /**
     * List all vehicles
     *
     * * @OA\Get(
     *     summary="List all vehicles",
     *     path="/api/v1/vehicle",
     *     security={
     *       {"AuthJWT": {}}
     *      },
     *     @OA\Response(
     *          response=200,
     *          description="Vehicle list response",
     *          @OA\JsonContent(
     *              required={"status, data"},
     *              @OA\Property(
     *                  property="status",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                     ref="#/components/schemas/VehicleResponseSchema"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationSchema")
     *     )
     * )
     *
     * @param Request $request
     * @param VehicleRepository $vehicleRepository
     * @return JsonResponse
     */
    public function list(Request $request, VehicleRepository $vehicleRepository)
    {
        try {
            $vehicleCollection = $vehicleRepository->getVehicles();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse("Error while fetching vehicles.", 500);
        }

        return $this->successDataResponse($vehicleCollection, 200);
    }
}
