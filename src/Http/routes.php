<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => '/marketmonitor',
    'namespace'=>'RecursiveTree\Seat\MarketMonitor\Http\Controllers'
], function () {
    Route::get('/table', [
        'as' => 'marketmonitor::table',
        'uses' => 'MarketMonitorController@index',
    ]);

    Route::get('/locations', [
        'as' => 'marketmonitor::locations',
        'uses' => 'MarketMonitorController@getLocations',
    ]);
});