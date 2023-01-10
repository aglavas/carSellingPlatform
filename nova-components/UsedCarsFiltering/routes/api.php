<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/filtered-options', function(Request $request, \Efdi\UsedCarsFiltering\FilteringService $filteringService) {
    $options = $filteringService->getFilteredOptions($request);

    return $options;
});

Route::post('/notification/seen', function(Request $request, \App\Service\NotificationService $notificationService) {
    $notificationService->markAsSeen($request->input('params.list_type', null));

    return true;
});
