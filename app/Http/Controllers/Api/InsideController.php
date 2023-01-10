<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsideStoreRequest;
use App\Service\CarUploadService;
use App\Parsers\InsideParser;
use Illuminate\Http\JsonResponse;

class InsideController extends Controller
{
    /**
     * Store vehicle from Inside
     *
     * * @OA\Post(
     *     summary="Store a single vehicle from Inside",
     *     path="/api/v1/inside/vehicle",
     *     security={
     *       {"AuthJWT": {}}
     *      },
     *      @OA\RequestBody(
     *          description="Request body for vehicle store",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/InsideVehicleStoreRequestSchema")
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
     * @param InsideStoreRequest $request
     * @param CarUploadService $carUploadService
     * @return JsonResponse
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function store(InsideStoreRequest $request , CarUploadService $carUploadService)
    {
        $result = $carUploadService->startUpload($request->all(), CarUploadService::SOURCE_JSON, InsideParser::class);

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
}
