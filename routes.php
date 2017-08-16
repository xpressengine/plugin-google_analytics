<?php

Route::settings('ga', function () {
    Route::get('setting', [
        'as' => 'edit',
        'uses' => 'ManageController@getSetting'
    ]);
    Route::post('setting', [
        'as' => 'update',
        'uses' => 'ManageController@postSetting'
    ]);
}, ['as' => 'ga::setting.']);

Route::fixed('ga', function () {
    Route::group(['prefix' => 'api', 'as' => 'ga::api.', 'middleware' => 'settings'], function () {
        Route::get('visit', ['as' => 'visit', 'uses' => 'ApiController@visit']);
        Route::get('browser', ['as' => 'browser', 'uses' => 'ApiController@browser']);
        Route::get('source', ['as' => 'source', 'uses' => 'ApiController@source']);
        Route::get('pv', ['as' => 'pv', 'uses' => 'ApiController@pv']);
        Route::get('device', ['as' => 'device', 'uses' => 'ApiController@device']);
    });
});