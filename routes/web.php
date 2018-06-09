<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',function(){
    if (Auth::check()) {
        return redirect('home');
    } else {
        return redirect('login');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// == Role == //
Route::get('role/loaddata','RoleController@loadData');
Route::post('role/deleterole','RoleController@deleteRole');
Route::resource('role','RoleController');

// == Permission == //
Route::get('permission/loaddata','PermissionController@loadData');
Route::post('permission/delete','PermissionController@delete');
Route::resource('permission','PermissionController');

// == User == //
Route::get('user/loaddata','UserController@loadData');
Route::post('user/delete','UserController@delete');
Route::resource('user','UserController');

