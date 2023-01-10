<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => '\App\Http\Controllers\Api'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('pricing', function (Request $request, \App\Service\CarBidding\BiddingService $biddingService) {
            $user = $_SERVER['PHP_AUTH_USER'];
            $pass = $_SERVER['PHP_AUTH_PW'];

            activity('pricing_credentials')->withProperties([$user, $pass])->log('Received pricing credentials');
            activity('pricing')->withProperties($request->input())->log('Received pricing information');

            try {
                $biddingService->receiveCarData($request, $pass);
            } catch (\Exception $exception) {

                activity('pricing_receive_fail')->withProperties($exception)->log('Pricing receive fail');

                if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                    return response(['status' => 'fail'])->setStatusCode(400);
                }

                return response(['status' => 'fail'])->setStatusCode(500);
            }

            return response(['status' => 'success']);
        });
        /////

        Route::post('inside/vehicle', 'InsideController@store')->middleware('role:Uploader');

        Route::post('vehicle/import', 'VehicleController@import')->middleware('role:Uploader');
        Route::post('vehicle', 'VehicleController@store')->middleware('role:Uploader');
        Route::get('vehicle', 'VehicleController@list');
        Route::delete('vehicle/{vehicle}', 'VehicleController@destroy')->middleware('role:Uploader');
        Route::put('vehicle/{vehicle}', 'VehicleController@update')->middleware('role:Uploader');
    });
});
