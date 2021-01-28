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

//ADUAN
Route::get('/aduan','AduanController@aduanBaru')->name('aduanBaru');
Route::get('/borang-aduan','AduanController@borangAduan')->name('borangAduan');
Route::get('/semak-aduan','AduanController@semakAduan')->name('semakAduan');
Route::post('simpanAduan','AduanController@simpanAduan');
Route::get('/cariJenis', 'AduanController@cariJenis');
Route::get('/cariSebab', 'AduanController@cariSebab');

Route::get('/senarai-aduan','AduanController@senaraiAduan')->name('senarai');
Route::post('senaraiAduan', 'AduanController@data_senarai');
Route::post('updateJuruteknik', 'AduanController@updateJuruteknik');
Route::delete('senarai-aduan/{id}', 'AduanController@padamAduan');
Route::get('/info-aduan/{id}', 'AduanController@infoAduan')->name('info');
Route::post('simpanPenambahbaikan','AduanController@simpanPenambahbaikan');
Route::post('kemaskiniPenambahbaikan','AduanController@kemaskiniPenambahbaikan');
Route::post('simpanStatus','AduanController@simpanStatus');
Route::get('/senarai-selesai','AduanController@senaraiSelesai')->name('selesai');
Route::post('senaraiSelesai', 'AduanController@data_selesai');
Route::get('/senarai-kiv','AduanController@senaraiKiv')->name('kiv');
Route::post('senaraiKiv', 'AduanController@data_kiv');

//KATEGORI
Route::resource('kategori-aduan', 'KategoriAduanController');
Route::post('kategoriAduan', 'KategoriAduanController@data_kategori');  
Route::post('tambahKategori','KategoriAduanController@tambahKategori');
Route::post('kemaskiniKategori','KategoriAduanController@kemaskiniKategori');

//JENIS
Route::resource('jenis-kerosakan', 'JenisKerosakanController');
Route::post('jenisKerosakan', 'JenisKerosakanController@data_jenis');  
Route::post('tambahJenis','JenisKerosakanController@tambahJenis');
Route::post('kemaskiniJenis','JenisKerosakanController@kemaskiniJenis');

//SEBAB
Route::resource('sebab-kerosakan', 'SebabKerosakanController');
Route::post('sebabKerosakan', 'SebabKerosakanController@data_sebab');  
Route::post('tambahSebab','SebabKerosakanController@tambahSebab');
Route::post('kemaskiniSebab','SebabKerosakanController@kemaskiniSebab');

//COVID19
Route::get('/declarationForm/{id}','CovidController@form')->name('form');
Route::post('formStore','CovidController@formStore');
Route::post('declareList', 'CovidController@data_declare');
Route::get('/declare-info/{id}', 'CovidController@declareInfo')->name('declareInfo');
Route::delete('declareList/{id}', 'CovidController@declareDelete');
Route::get('/historyForm/{id}','CovidController@history')->name('history');
Route::post('historyList', 'CovidController@data_history');
Route::get('/history-info/{id}', 'CovidController@historyInfo')->name('historyInfo');
Route::delete('historyList/{id}', 'CovidController@historyDelete');

// Change Password
Route::get('change-password','ChangePasswordController@index');
Route::post('update-password','ChangePasswordController@store')->name('change.password');