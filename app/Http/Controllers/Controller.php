<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success data response
     *
     * @param $data
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successDataResponse($data, $statusCode)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ])->setStatusCode($statusCode);
    }

    /**
     * Error message response
     *
     * @param $message
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorMessageResponse($message, $statusCode)
    {
        return response()->json([
            'error' => [
                [
                    'type' => "general",
                    'field' => null,
                    'message' => $message
                ]
            ]
        ], $statusCode);
    }

    /**
     * Success message response
     *
     * @param $message
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successMessageResponse($message, $statusCode)
    {
        return response()->json([
            'status' => 'success',
            'message'=> $message
        ], $statusCode);
    }

    /**
     * Message response
     *
     * @param $status
     * @param $message
     * @param null $errors
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function messageResponse($status, $message, $errors = null, $statusCode)
    {
        if ($errors) {
            return response()->json([
                'status' => $status,
                'message'=> $message,
                'errors'=> $errors,
            ], $statusCode);
        }

        return response()->json([
            'status' => $status,
            'message'=> $message,
        ], $statusCode);
    }
}
