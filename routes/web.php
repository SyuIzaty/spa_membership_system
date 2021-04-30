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
Route::get('/borang-aduan','AduanController@borangAduan')->name('borangAduan');
Route::post('simpanAduan','AduanController@simpanAduan');
Route::get('/cariJenis', 'AduanController@cariJenis');
Route::get('/cariSebab', 'AduanController@cariSebab');
Route::get('/aduan','AduanController@aduan')->name('aduan');
Route::post('data_aduan', 'AduanController@data_aduan');
Route::get('/maklumat-aduan/{id}', 'AduanController@maklumatAduan')->name('maklumatAduan');
Route::get('resit/{filename}/{type}','AduanController@failResit');
Route::get('get-file-resit/{filename}','AduanController@getImej');
Route::post('simpanPengesahan','AduanController@simpanPengesahan');
Route::post('/aduan/editDeleteJuruteknik','AduanController@editDeleteJuruteknik')->name('aduan.editDeleteJuruteknik');
Route::post('updateTahap', 'AduanController@updateTahap');
Route::get('padamAlatan/{id}/{id_aduan}', 'AduanController@padamAlatan')->name('padamAlatan');
Route::get('get-file-gambar/{filename}','AduanController@getGambar');
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
Route::get('/senarai-bertindih','AduanController@senaraiBertindih')->name('bertindih');
Route::post('senaraiBertindih', 'AduanController@data_bertindih');
Route::get('/pdfAduan/{id}', 'AduanController@pdfAduan')->name('pdfAduan');
Route::get('/export_aduan', 'AduanController@aduan_all')->name('exportAduan');
Route::post('/data_aduanexport', 'AduanController@data_aduanexport');
Route::get('/aduanExport', 'AduanController@aduans');
Route::post('/aduanExport', 'AduanController@aduans');
Route::get('exportaduan/{kategori?}/{status?}/{tahap?}/{bulan?}','AduanController@aduans');
Route::get('/juruExport/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'AduanController@jurutekniks');
Route::post('/juruExport/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'AduanController@jurutekniks');
Route::get('juruaduan/{juruteknik?}/{stat?}/{kate?}/{bul?}','AduanController@jurutekniks');
Route::get('/individuExport/{stats?}/{kates?}/{buls?}', 'AduanController@individu');
Route::post('/individuExport/{stats?}/{kates?}/{buls?}', 'AduanController@individu');
Route::get('aduanIndividu/{stats?}/{kates?}/{buls?}','AduanController@individu');

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

//ALAT
Route::resource('alat-ganti', 'AlatGantiController');
Route::post('alatGanti', 'AlatGantiController@data_alat');  
Route::post('tambahAlat','AlatGantiController@tambahAlat');
Route::post('kemaskiniALat','AlatGantiController@kemaskiniALat');

//COVID19
Route::get('/declarationForm','CovidController@form')->name('form');
Route::post('formStore','CovidController@formStore');
Route::post('declareList', 'CovidController@data_declare');
Route::get('/declare-info/{id}', 'CovidController@declareInfo')->name('declareInfo');
Route::delete('declareList/{id}', 'CovidController@declareDelete');
Route::get('/historyForm/{id}','CovidController@history')->name('history');
Route::post('historyList', 'CovidController@data_history');
Route::get('/history-info/{id}', 'CovidController@historyInfo')->name('historyInfo');
Route::delete('historyList/{id}', 'CovidController@historyDelete');
Route::get('/declarationList/{id}','CovidController@list')->name('list');
Route::get('/declareNew/{id}','CovidController@new')->name('new');
Route::post('newStore','CovidController@newStore');
Route::get('/findUser', 'CovidController@findUser');
Route::get('/selfHistory/{id}','CovidController@selfHistory')->name('selfHistory');
Route::post('historySelf', 'CovidController@data_selfHistory');
Route::get('/catA','CovidController@categoryA');
Route::post('AList', 'CovidController@data_catA');
Route::get('/catB','CovidController@categoryB');
Route::post('BList', 'CovidController@data_catB');
Route::get('/catC','CovidController@categoryC');
Route::post('CList', 'CovidController@data_catC');
Route::get('/catD','CovidController@categoryD');
Route::post('DList', 'CovidController@data_catD');
Route::get('/catE','CovidController@categoryE');
Route::post('EList', 'CovidController@data_catE');
Route::get('/followup-list/{id}', 'CovidController@followList')->name('followList');
Route::post('addFollowup','CovidController@addFollowup');
Route::get('delFollowup/{id}/{cov_id}', 'CovidController@delFollowup')->name('delFollowup');
Route::post('updateFollowup','CovidController@updateFollowup');
Route::get('/followup-edit/{id}', 'CovidController@followEdit')->name('followEdit');
Route::get('/covid','CovidController@openForm')->name('openForm');
Route::post('openFormStore','CovidController@storeOpenForm');
Route::get('/add-form','CovidController@addForm');
Route::get('/export_covid', 'CovidController@covid_all')->name('covidreport');
Route::post('/data_covidexport', 'CovidController@data_covidexport');
Route::get('/covidExport', 'CovidController@exports');
Route::post('/covidExport', 'CovidController@exports');
Route::get('exportcovid/{name?}/{category?}/{position?}/{department?}/{date?}','CovidController@exports');
Route::get('/export-undeclare/{datek?}/{cates?}', 'CovidController@exportUndeclare');
Route::post('/export-undeclare/{datek?}/{cates?}', 'CovidController@exportUndeclare');
Route::get('exportundeclare/{datek?}/{cates?}','CovidController@exportUndeclare');
Route::get('/remainder/{date?}/{cate?}', 'CovidController@sendRemainder')->name('remainder');

// Change Password
Route::get('change-password','ChangePasswordController@index');
Route::post('update-password','ChangePasswordController@store')->name('change.password');


//Geolocation
Route::get('/geolocation','GeolocationController@index');