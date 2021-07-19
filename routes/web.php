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
Route::get('/dashboard-aduan','AduanController@index');
Route::get('/download/{id}', 'AduanController@downloadBorang')->name('downloadBorang');
Route::get('pembaikan/{filename}/{type}','AduanController@failPembaikan');
Route::get('padamGambar/{id}/{id_aduan}', 'AduanController@padamGambar')->name('padamGambar');

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

//ASSET-TYPE
Route::resource('asset-type', 'AssetTypeController');
Route::post('assetType', 'AssetTypeController@data_asset');
Route::post('addType','AssetTypeController@addType');
Route::post('updateType','AssetTypeController@updateType');

//CUSTODIAN-DEPARTMENT
Route::resource('asset-custodian', 'AssetCustodianController');
Route::post('addDepartment','AssetCustodianController@addDepartment');
Route::get('/custodian-list/{id}', 'AssetCustodianController@custodianList');
Route::post('/storeDepartCust','AssetCustodianController@storeDepartCust');
Route::delete('deleteCustodian/{id}', 'AssetCustodianController@deleteCustodian')->name('deleteCustodian');
Route::delete('deleteDepartment/{id}', 'AssetCustodianController@deleteDepartment')->name('deleteDepartment');

//Asset
Route::get('/asset-index', 'AssetController@assetIndex');
Route::get('/asset-new', 'AssetController@assetNew');
Route::post('newAssetStore', 'AssetController@newAssetStore')->name('newAsset');
Route::get('/findAssetType', 'AssetController@findAssetType');
Route::get('/findCustodian', 'AssetController@findCustodian');
Route::post('assetList', 'AssetController@data_assetList');
Route::delete('asset-index/{id}', 'AssetController@assetDelete');
Route::get('/asset-detail/{id}', 'AssetController@assetDetail');
Route::get('get-file-image/{filename}','AssetController@getImage');
Route::post('assetUpdate', 'AssetController@assetUpdate');
Route::post('assetPurchaseUpdate', 'AssetController@assetPurchaseUpdate');
Route::post('createCustodian','AssetController@createCustodian');
Route::post('updateCustodian', 'AssetController@updateCustodian');
Route::get('/assetPdf/{id}', 'AssetController@assetPdf')->name('assetPdf');
Route::get('/export_asset', 'AssetController@asset_all')->name('assetreport');
Route::post('/data_assetexport', 'AssetController@data_assetexport');
Route::get('/assetExport', 'AssetController@exports');
Route::post('/assetExport', 'AssetController@exports');
Route::get('exportasset/{department?}/{availability?}/{type?}/{status?}','AssetController@exports');
Route::get('deleteImage/{id}/{asset_id}', 'AssetController@deleteImage')->name('deleteImage');
Route::get('deleteSet/{id}/{asset_id}', 'AssetController@deleteSet')->name('deleteSet');
Route::post('updateSet', 'AssetController@updateSet');

//Stock
Route::get('/stock-index', 'StockController@stockIndex');
Route::post('newStockStore', 'StockController@newStockStore')->name('newStock');
Route::post('stockList', 'StockController@data_stockList');
Route::delete('stock-index/{id}', 'StockController@stockDelete');
Route::get('/stock-detail/{id}', 'StockController@stockDetail');
Route::get('get-file-images/{filename}','StockController@getImages');
Route::post('stockUpdate', 'StockController@stockUpdate');
Route::post('createTransIn','StockController@createTransIn');
Route::post('createTransOut','StockController@createTransOut');
Route::get('/stockPdf/{id}', 'StockController@stockPdf')->name('stockPdf');
Route::get('deleteImages/{id}/{stock_id}', 'StockController@deleteImages')->name('deleteImages');
Route::get('deleteTrans/{id}/{stock_id}', 'StockController@deleteTrans')->name('deleteTrans');
Route::post('updateTransin', 'StockController@updateTransin');
Route::post('updateTransout', 'StockController@updateTransout');
Route::get('/export-stock', 'StockController@exportStock');

//Borrow
Route::get('/borrow-index', 'BorrowController@borrowIndex');
Route::get('/borrow-new', 'BorrowController@borrowNew');
Route::post('newBorrowStore', 'BorrowController@newBorrowStore')->name('newBorrow');
Route::post('borrowList', 'BorrowController@data_borrowList');
Route::delete('borrow-index/{id}', 'BorrowController@borrowDelete');
Route::get('/borrow-detail/{id}', 'BorrowController@borrowDetail');
Route::post('borrowUpdate', 'BorrowController@borrowUpdate');
Route::get('/findUsers', 'BorrowController@findUsers');
Route::get('/findAsset', 'BorrowController@findAsset');
Route::get('/findAssets', 'BorrowController@findAssets');
Route::get('/monitor-list', 'BorrowController@monitorList');
Route::post('monitorList', 'BorrowController@data_monitorList');
Route::get('/export-borrow', 'BorrowController@borrow_all')->name('borrowreport');
Route::post('/data_borrowexport', 'BorrowController@data_borrowexport');
Route::get('/borrowExport', 'BorrowController@exports');
Route::post('/borrowExport', 'BorrowController@exports');
Route::get('exportborrow/{asset?}/{borrower?}/{status?}','BorrowController@exports');

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

// Vaccine
Route::get('/vaccineForm','VaccineController@form')->name('vaccineForm');
Route::post('vaccineStore','VaccineController@vaccineStore');
Route::post('vaccineUpdate','VaccineController@vaccineUpdate');
Route::get('/vaccineIndex','VaccineController@vaccineIndex')->name('vaccineIndex');
Route::post('vaccineList', 'VaccineController@data_vaccine');
Route::get('/vaccine-detail/{id}', 'VaccineController@vaccineDetail')->name('vaccineDetail');
Route::get('/export-vaccine', 'VaccineController@exportVaccine');
Route::delete('deleteVaccine/{id}', 'VaccineController@deleteVaccine')->name('deleteVaccine');

// Change Password
Route::get('change-password','ChangePasswordController@index');
Route::post('update-password','ChangePasswordController@store')->name('change.password');


//Geolocation
Route::get('/geolocation','GeolocationController@index');

//Short Course Management
//Event Management
//EventParticipant
Route::post('/event/{id}/events-participants/data-applicants','ShortCourseManagement\EventManagement\EventParticipantController@dataApplicants');
Route::post('/event/{id}/events-participants/data-no-payment-yet','ShortCourseManagement\EventManagement\EventParticipantController@dataNoPaymentYet');
Route::post('/event/{id}/events-participants/data-payment-wait-for-verification','ShortCourseManagement\EventManagement\EventParticipantController@dataPaymentWaitForVerification');
Route::post('/event/{id}/events-participants/data-ready-for-event','ShortCourseManagement\EventManagement\EventParticipantController@dataReadyForEvent');
Route::post('/event/{id}/events-participants/data-disqualified','ShortCourseManagement\EventManagement\EventParticipantController@dataDisqualified');
Route::post('/event/{id}/events-participants/data-expected-attendances','ShortCourseManagement\EventManagement\EventParticipantController@dataExpectedAttendances');
Route::post('/event/{id}/events-participants/data-attended-participants','ShortCourseManagement\EventManagement\EventParticipantController@dataAttendedParticipants');
Route::post('/event/{id}/events-participants/data-not-attended-participants','ShortCourseManagement\EventManagement\EventParticipantController@dataNotAttendedParticipants');
Route::post('/event/{id}/events-participants/data-participant-post-event','ShortCourseManagement\EventManagement\EventParticipantController@dataParticipantPostEvent');
Route::post('/event/{id}/events-participants/data-completed-participation-process','ShortCourseManagement\EventManagement\EventParticipantController@dataCompletedParticipationProcess');
Route::post('/event/{id}/events-participants/data-not-completed-participation-process','ShortCourseManagement\EventManagement\EventParticipantController@dataNotCompletedParticipationProcess');

//Event
Route::post('/events/data','ShortCourseManagement\EventManagement\EventController@data');
Route::post('/events/update/{id}','ShortCourseManagement\EventManagement\EventController@update');
Route::get('/events', 'ShortCourseManagement\EventManagement\EventController@index');
Route::post('/event','ShortCourseManagement\EventManagement\EventController@addEvent');
Route::get('/event/{id}', 'ShortCourseManagement\EventManagement\EventController@show');
Route::delete('/event/{id}', 'ShortCourseManagement\EventManagement\EventController@deleteEvent');

//Participant
Route::get('/participant/search-by-ic/{ic}','ShortCourseManagement\People\Participant\ParticipantController@searchByIc');
Route::get('/participant/search-by-representative-ic/{ic}','ShortCourseManagement\People\Participant\ParticipantController@searchByRepresentativeIc');


