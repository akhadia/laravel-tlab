<?php

Route::group(['middleware' => 'web', 'prefix' => 'api', 'namespace' => 'Modules\API\Http\Controllers'], function()
{
    Route::get('/', 'APIController@index');
});
