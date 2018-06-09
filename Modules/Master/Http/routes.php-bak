<?php

Route::group(['middleware' => 'web', 'prefix' => 'master', 'namespace' => 'Modules\Master\Http\Controllers'], function()
{
    Route::get('/', 'MasterController@index');

    //== Autocomplete ==//
    Route::get('autocomplete/{method}','AutocompleteController@search');

    //== Bahan ==//
    Route::get('bahan/loaddatabahan','BahanController@loadDataBahan');
    Route::get('bahan/delete/{id}','BahanController@delete');
    Route::resource('bahan','BahanController');

    //== Satuan ==//
    Route::get('satuan/getsatuan/{id}','SatuanController@getSatuan');
    Route::get('satuan/loaddatapopupsatuan','SatuanController@loadDataPopupSatuan');
    Route::get('satuan/popupsatuan','SatuanController@popupSatuan');
    Route::get('satuan/loaddatasatuan','SatuanController@loadDataSatuan');
    Route::get('satuan/delete/{id}','SatuanController@delete');
    Route::resource('satuan','SatuanController');

    //== Kategori ==//
    Route::get('kategori/loaddatakategori','KategoriController@loadDataKategori');
    Route::get('kategori/delete/{id}','KategoriController@delete');
    Route::resource('kategori','KategoriController');

    //== Resep ==//
    Route::get('resep/{id}/detailresep','ResepController@detailResep');
    Route::post('resep/addresep',['as' => 'resep.addresep', 'uses' => 'ResepController@addResep']);
    Route::put('resep/editstatusresep','ResepController@editStatusResep');
    Route::put('resep/addeditresep/{id}',['as' => 'resep.addeditresep', 'uses' => 'ResepController@addEditResep']);
    Route::get('resep/createresep','ResepController@createResep');
    Route::get('resep/loaddataresep','ResepController@loadDataResep');
    Route::resource('resep','ResepController');

    //== API ==//
    Route::get('satuan', 'SatuanController@index');
    Route::get('satuan/{id}', 'ArticleController@show');
    Route::post('satuan', 'ArticleController@store');
    Route::put('satuan/{id}', 'ArticleController@update');
    Route::delete('satuan/{id}', 'ArticleController@delete');
    
});
