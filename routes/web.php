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

Route::get('/', function () {
   return redirect('/login');
});

Route::view('/reset_password', 'auth.passwords.email')->name('reset_password');

Route::get('home','DashboardController@index');


Auth::routes();

//ROLE
Route::resource('/role','RoleController');
Route::post('/data_allrole', 'RoleController@data_allrole');
Route::get('delete/{id}/{role_id}', 'RoleController@delete')->name('role.delete');

//PERMISSION
Route::resource('permission', 'PermissionController');
Route::post('/data_allpermission', 'PermissionController@data_allpermission');

//MODULE PERMISSION
Route::resource('/module-auth', 'ModuleAuthController');
Route::post('/data_moduleauth', 'ModuleAuthController@data_moduleauth');
Route::get('/test','ApplicantController@test');

