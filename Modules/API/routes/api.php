<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'Modules\API\Http\Controllers'], function()
{
    //-- Authentifikasi ==//
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->middleware('auth:api');

    Route::group(['middleware' => 'auth:api'], function() {

        //== Satuan ==//
        Route::get('satuan', 'SatuanController@index');
        Route::get('satuan/{id}', 'SatuanController@show');
        // Route::post('satuan', 'SatuanController@store');
        // Route::put('satuan/{id}', 'SatuanController@update');
        // Route::delete('satuan/{id}', 'SatuanController@delete');

        //== Bahan ==//
        Route::get('bahan', 'BahanController@index');
        Route::get('bahan/{id}', 'BahanController@show');
        // Route::post('bahan', 'BahanController@store');
        // Route::put('bahan/{id}', 'BahanController@update');
        // Route::delete('bahan/{id}', 'BahanController@delete');

        //== Kategori ==//
        Route::get('kategori', 'KategoriController@index');
        Route::get('kategori/{id}', 'KategoriController@show');
        // Route::post('kategori', 'KategoriController@store');
        // Route::put('kategori/{id}', 'KategoriController@update');
        // Route::delete('kategori/{id}', 'KategoriController@delete');

        //== Resep ==//
        Route::get('resep', 'ResepController@index');
        Route::get('resep/{id}', 'ResepController@show');

        //== Resep Detail==//
        // Route::get('resep', 'ResepController@index');
        Route::get('resepdetail/{id}', 'ResepDetailController@show');

    });
 
    
});




