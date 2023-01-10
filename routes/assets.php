<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'    => config('static-image-cache.cache_path_prefix'),
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'assetCache',
], function ()
{
    Route::get('/{slug}', ['as' => 'static-image-cache.image-proxy', 'uses' => 'ProxyController@image'])
        ->where('slug', '.*');
});
