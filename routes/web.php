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

Route::get('home', 'DashboardController@index');

Auth::routes();

//ROLE
Route::resource('/role', 'RoleController');
Route::post('/data_allrole', 'RoleController@data_allrole');
Route::get('delete/{id}/{role_id}', 'RoleController@delete')->name('role.delete');

//PERMISSION
Route::resource('permission', 'PermissionController');
Route::post('/data_allpermission', 'PermissionController@data_allpermission');

//MODULE PERMISSION
Route::resource('/module-auth', 'ModuleAuthController');
Route::post('/data_moduleauth', 'ModuleAuthController@data_moduleauth');
Route::get('/test', 'ApplicantController@test');

Route::group(['middleware' => 'auth'], function () {

    // Aduan
    Route::get('/borang-aduan', 'AduanController@borangAduan')->name('borangAduan');
    Route::post('simpanAduan', 'AduanController@simpanAduan');
    Route::get('/cariJenis', 'AduanController@cariJenis');
    Route::get('/cariSebab', 'AduanController@cariSebab');
    Route::get('/aduan', 'AduanController@aduan')->name('aduan');
    Route::post('data_aduan', 'AduanController@data_aduan');
    Route::get('/maklumat-aduan/{id}', 'AduanController@maklumatAduan')->name('maklumatAduan');
    Route::get('resit/{filename}/{type}', 'AduanController@failResit');
    Route::get('get-file-resit/{filename}', 'AduanController@getImej');
    Route::post('simpanPengesahan', 'AduanController@simpanPengesahan');
    Route::post('/aduan/editDeleteJuruteknik', 'AduanController@editDeleteJuruteknik')->name('aduan.editDeleteJuruteknik');
    Route::post('updateTahap', 'AduanController@updateTahap');
    Route::get('padamAlatan/{id}/{id_aduan}', 'AduanController@padamAlatan')->name('padamAlatan');
    Route::get('get-file-gambar/{filename}', 'AduanController@getGambar');
    Route::get('/senarai-aduan', 'AduanController@senaraiAduan')->name('senarai');
    Route::post('senaraiAduan', 'AduanController@data_senarai');
    Route::post('updateJuruteknik', 'AduanController@updateJuruteknik');
    Route::delete('senarai-aduan/{id}', 'AduanController@padamAduan');
    Route::get('/info-aduan/{id}', 'AduanController@infoAduan')->name('info');
    Route::post('simpanPenambahbaikan', 'AduanController@simpanPenambahbaikan');
    Route::post('kemaskiniPenambahbaikan', 'AduanController@kemaskiniPenambahbaikan');
    Route::post('simpanStatus', 'AduanController@simpanStatus');
    Route::get('/senarai-selesai', 'AduanController@senaraiSelesai')->name('selesai');
    Route::post('senaraiSelesai', 'AduanController@data_selesai');
    Route::get('/senarai-kiv', 'AduanController@senaraiKiv')->name('kiv');
    Route::post('senaraiKiv', 'AduanController@data_kiv');
    Route::get('/senarai-bertindih', 'AduanController@senaraiBertindih')->name('bertindih');
    Route::post('senaraiBertindih', 'AduanController@data_bertindih');
    Route::get('/pdfAduan/{id}', 'AduanController@pdfAduan')->name('pdfAduan');
    Route::get('/export_aduan', 'AduanController@aduan_all')->name('exportAduan');
    Route::post('/data_aduanexport', 'AduanController@data_aduanexport');
    Route::get('/aduanExport', 'AduanController@aduans');
    Route::post('/aduanExport', 'AduanController@aduans');
    Route::get('exportaduan/{kategori?}/{status?}/{tahap?}/{bulan?}', 'AduanController@aduans');
    Route::get('/juruExport/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'AduanController@jurutekniks');
    Route::post('/juruExport/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'AduanController@jurutekniks');
    Route::get('juruaduan/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'AduanController@jurutekniks');
    Route::get('/individuExport/{stats?}/{kates?}/{buls?}', 'AduanController@individu');
    Route::post('/individuExport/{stats?}/{kates?}/{buls?}', 'AduanController@individu');
    Route::get('aduanIndividu/{stats?}/{kates?}/{buls?}', 'AduanController@individu');
    Route::get('/dashboard-aduan', 'AduanController@index');
    Route::get('/download/{id}', 'AduanController@downloadBorang')->name('downloadBorang');
    Route::get('pembaikan/{filename}/{type}', 'AduanController@failPembaikan');
    Route::get('padamGambar/{id}/{id_aduan}', 'AduanController@padamGambar')->name('padamGambar');

    // Kategori
    Route::resource('kategori-aduan', 'KategoriAduanController');
    Route::post('kategoriAduan', 'KategoriAduanController@data_kategori');
    Route::post('tambahKategori', 'KategoriAduanController@tambahKategori');
    Route::post('kemaskiniKategori', 'KategoriAduanController@kemaskiniKategori');

    // Jenis
    Route::resource('jenis-kerosakan', 'JenisKerosakanController');
    Route::post('jenisKerosakan', 'JenisKerosakanController@data_jenis');
    Route::post('tambahJenis', 'JenisKerosakanController@tambahJenis');
    Route::post('kemaskiniJenis', 'JenisKerosakanController@kemaskiniJenis');

    // Sebab
    Route::resource('sebab-kerosakan', 'SebabKerosakanController');
    Route::post('sebabKerosakan', 'SebabKerosakanController@data_sebab');
    Route::post('tambahSebab', 'SebabKerosakanController@tambahSebab');
    Route::post('kemaskiniSebab', 'SebabKerosakanController@kemaskiniSebab');

    // Alat
    Route::resource('alat-ganti', 'AlatGantiController');
    Route::post('alatGanti', 'AlatGantiController@data_alat');
    Route::post('tambahAlat', 'AlatGantiController@tambahAlat');
    Route::post('kemaskiniALat', 'AlatGantiController@kemaskiniALat');

    // AssetType
    Route::resource('asset-type', 'AssetTypeController');
    Route::post('assetType', 'AssetTypeController@data_asset');
    Route::post('addType', 'AssetTypeController@addType');
    Route::post('updateType', 'AssetTypeController@updateType');

    // Custodian-Department
    Route::resource('asset-custodian', 'AssetCustodianController');
    Route::post('addDepartment', 'AssetCustodianController@addDepartment');
    Route::get('/custodian-list/{id}', 'AssetCustodianController@custodianList');
    Route::post('/storeDepartCust', 'AssetCustodianController@storeDepartCust');
    Route::delete('deleteCustodian/{id}', 'AssetCustodianController@deleteCustodian')->name('deleteCustodian');
    Route::delete('deleteDepartment/{id}', 'AssetCustodianController@deleteDepartment')->name('deleteDepartment');

    // Asset
    Route::get('/asset-index', 'AssetController@assetIndex');
    Route::get('/asset-new', 'AssetController@assetNew');
    Route::post('newAssetStore', 'AssetController@newAssetStore')->name('newAsset');
    Route::get('/findAssetType', 'AssetController@findAssetType');
    Route::get('/findCustodian', 'AssetController@findCustodian');
    Route::post('assetList', 'AssetController@data_assetList');
    Route::delete('asset-index/{id}', 'AssetController@assetDelete');
    Route::get('/asset-detail/{id}', 'AssetController@assetDetail');
    Route::post('assetUpdate', 'AssetController@assetUpdate');
    Route::post('assetPurchaseUpdate', 'AssetController@assetPurchaseUpdate');
    Route::post('createCustodian', 'AssetController@createCustodian');
    Route::post('updateCustodian', 'AssetController@updateCustodian');
    Route::get('/assetPdf/{id}', 'AssetController@assetPdf')->name('assetPdf');
    Route::get('/export_asset', 'AssetController@asset_all')->name('assetreport');
    Route::post('/data_assetexport', 'AssetController@data_assetexport');
    Route::get('/assetExport', 'AssetController@exports');
    Route::post('/assetExport', 'AssetController@exports');
    Route::get('exportasset/{department?}/{availability?}/{type?}/{status?}', 'AssetController@exports');
    Route::get('deleteImage/{id}/{asset_id}', 'AssetController@deleteImage')->name('deleteImage');
    Route::get('deleteSet/{id}/{asset_id}', 'AssetController@deleteSet')->name('deleteSet');
    Route::post('updateSet', 'AssetController@updateSet');
    Route::get('/trailPdf/{id}', 'AssetController@trailPdf')->name('trailPdf');
    Route::get('/custodianPdf/{id}', 'AssetController@custodianPdf')->name('custodianPdf');
    Route::get('/verify-list', 'AssetController@verifyList');
    Route::post('verifyList', 'AssetController@data_verifyList');
    Route::post('verification/{id}', 'AssetController@updateVerification');
    Route::get('/individual-list', 'AssetController@individualList');
    Route::post('individualList', 'AssetController@data_individualList');
    Route::get('/export-individual-asset', 'AssetController@exportIndividualAsset');
    Route::get('/asset-info/{id}', 'AssetController@assetInfo');
    Route::get('/asset-upload', 'AssetController@bulkUpload');
    Route::post('import-asset','AssetController@importAsset');
    Route::get('/assetTemplates','AssetController@assetTemplate');

    // Stock
    Route::get('/stock-index', 'StockController@stockIndex');
    Route::post('newStockStore', 'StockController@newStockStore')->name('newStock');
    Route::post('stockList', 'StockController@data_stockList');
    Route::delete('stock-index/{id}', 'StockController@stockDelete');
    Route::get('/stock-detail/{id}', 'StockController@stockDetail');
    Route::get('get-file-images/{filename}', 'StockController@getImages');
    Route::post('stockUpdate', 'StockController@stockUpdate');
    Route::post('createTransIn', 'StockController@createTransIn');
    Route::post('createTransOut', 'StockController@createTransOut');
    Route::get('/stockPdf/{id}', 'StockController@stockPdf')->name('stockPdf');
    Route::get('deleteImages/{id}/{stock_id}', 'StockController@deleteImages')->name('deleteImages');
    Route::get('deleteTrans/{id}/{stock_id}', 'StockController@deleteTrans')->name('deleteTrans');
    Route::post('updateTransin', 'StockController@updateTransin');
    Route::post('updateTransout', 'StockController@updateTransout');
    Route::get('/export-stock', 'StockController@exportStock');

    // Borrow
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
    Route::get('exportborrow/{asset?}/{borrower?}/{status?}', 'BorrowController@exports');

    // Covid19
    Route::get('/declarationForm', 'CovidController@form')->name('form');
    Route::post('formStore', 'CovidController@formStore');
    Route::post('declareList', 'CovidController@data_declare');
    Route::get('/declare-info/{id}', 'CovidController@declareInfo')->name('declareInfo');
    Route::delete('declareList/{id}', 'CovidController@declareDelete');
    Route::get('/historyForm/{id}', 'CovidController@history')->name('history');
    Route::post('historyList', 'CovidController@data_history');
    Route::get('/history-info/{id}', 'CovidController@historyInfo')->name('historyInfo');
    Route::delete('historyList/{id}', 'CovidController@historyDelete');
    Route::get('/declarationList/{id}', 'CovidController@list')->name('list');
    Route::get('/declareNew/{id}', 'CovidController@new')->name('new');
    Route::post('newStore', 'CovidController@newStore');
    Route::get('/selfHistory/{id}', 'CovidController@selfHistory')->name('selfHistory');
    Route::post('historySelf', 'CovidController@data_selfHistory');
    Route::get('/catA', 'CovidController@categoryA');
    Route::post('AList', 'CovidController@data_catA');
    Route::get('/catB', 'CovidController@categoryB');
    Route::post('BList', 'CovidController@data_catB');
    Route::get('/catC', 'CovidController@categoryC');
    Route::post('CList', 'CovidController@data_catC');
    Route::get('/catD', 'CovidController@categoryD');
    Route::post('DList', 'CovidController@data_catD');
    Route::get('/catE', 'CovidController@categoryE');
    Route::post('EList', 'CovidController@data_catE');
    Route::get('/followup-list/{id}', 'CovidController@followList')->name('followList');
    Route::post('addFollowup', 'CovidController@addFollowup');
    Route::get('delFollowup/{id}/{cov_id}', 'CovidController@delFollowup')->name('delFollowup');
    Route::post('updateFollowup', 'CovidController@updateFollowup');
    Route::get('/followup-edit/{id}', 'CovidController@followEdit')->name('followEdit');
    Route::get('/export_covid', 'CovidController@covid_all')->name('covidreport');
    Route::post('/data_covidexport', 'CovidController@data_covidexport');
    Route::get('/covidExport', 'CovidController@exports');
    Route::post('/covidExport', 'CovidController@exports');
    Route::get('exportcovid/{name?}/{category?}/{position?}/{department?}/{date?}', 'CovidController@exports');
    Route::get('/export-undeclare/{datek?}/{cates?}', 'CovidController@exportUndeclare');
    Route::post('/export-undeclare/{datek?}/{cates?}', 'CovidController@exportUndeclare');
    Route::get('exportundeclare/{datek?}/{cates?}', 'CovidController@exportUndeclare');
    Route::get('/remainder/{date?}/{cate?}', 'CovidController@sendRemainder')->name('remainder');

    // Vaccine
    Route::get('/vaccineForm', 'VaccineController@form')->name('vaccineForm');
    Route::post('vaccineStore', 'VaccineController@vaccineStore');
    Route::post('vaccineUpdate', 'VaccineController@vaccineUpdate');
    Route::get('/vaccineIndex', 'VaccineController@vaccineIndex')->name('vaccineIndex');
    Route::post('vaccineList', 'VaccineController@data_vaccine');
    Route::get('/vaccine-detail/{id}', 'VaccineController@vaccineDetail')->name('vaccineDetail');
    Route::get('/export-vaccine', 'VaccineController@exportVaccine');
    Route::delete('deleteVaccine/{id}', 'VaccineController@deleteVaccine')->name('deleteVaccine');
    Route::get('/dependentForm', 'VaccineController@dependentForm')->name('dependentForm');
    Route::post('dependentStore', 'VaccineController@dependentStore');
    Route::post('dependentUpdate', 'VaccineController@dependentUpdate');
    Route::post('deleteChild/{id}', 'VaccineController@deleteChild')->name('deleteChild');

    // Change Password
    Route::get('change-password', 'ChangePasswordController@index');
    Route::post('update-password', 'ChangePasswordController@store')->name('change.password');

    // Geolocation
    Route::get('/geolocation', 'GeolocationController@index');

    //SCM - Trainer
    Route::get('/trainer/search-by-user_id/{user_id}', 'ShortCourseManagement\People\Trainer\TrainerController@searchByUserId');
    Route::get('/trainer/search-by-trainer_ic/{trainer_ic}', 'ShortCourseManagement\People\Trainer\TrainerController@searchByTrainerIc');

    Route::get('/trainers', 'ShortCourseManagement\People\Trainer\TrainerController@index');
    Route::get('/trainers/{id}', 'ShortCourseManagement\People\Trainer\TrainerController@show');
    Route::post('/trainers/data', 'ShortCourseManagement\People\Trainer\TrainerController@dataTrainers');
    Route::post('/trainers/update/{id}', 'ShortCourseManagement\People\Trainer\TrainerController@update');
    Route::post('/trainer', 'ShortCourseManagement\People\Trainer\TrainerController@store');
    Route::post('/trainer/delete/{id}', 'ShortCourseManagement\People\Trainer\TrainerController@delete');

    //SCM - Participants
    Route::get('/participant/search-by-participant_ic/{participant_ic}', 'ShortCourseManagement\People\Participant\ParticipantController@searchByParticipantIc');

    Route::get('/participants', 'ShortCourseManagement\People\Participant\ParticipantController@index');
    Route::post('/participant', 'ShortCourseManagement\People\Participant\ParticipantController@store');
    Route::get('/participants/{id}', 'ShortCourseManagement\People\Participant\ParticipantController@show');
    Route::post('/participants/data', 'ShortCourseManagement\People\Participant\ParticipantController@dataParticipants');
    Route::post('/participants/update/{id}', 'ShortCourseManagement\People\Participant\ParticipantController@update');
    Route::post('/participant/delete/{id}', 'ShortCourseManagement\People\Participant\ParticipantController@delete');


    //SCM - Contact Person
    Route::get('/contact_person/search-by-user_id/{user_id}', 'ShortCourseManagement\People\ContactPerson\ContactPersonController@searchByUserId');
    Route::get('/contact_person/search-by-contact_person_ic/{contact_person_ic}', 'ShortCourseManagement\People\ContactPerson\ContactPersonController@searchByContactPersonIc');

    //SCM - Shortcourse
    Route::get('/shortcourses', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@index');
    Route::post('/shortcourses/data', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@dataShortCourses');
    Route::get('/shortcourses/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@show');
    Route::get('event/shortcourse/search-by-id/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@searchById');
    Route::post('/shortcourses/update/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@update');
    Route::post('/shortcourse/topic/attached/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@storeTopicShortCourse');
    Route::post('/shortcourse/topic/detached/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@removeTopicShortCourse');
    Route::post('/shortcourse/delete/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@delete');
    Route::post('/shortcourse', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@store');
    Route::post('/shortcourse/event', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@storeShortCourseEvent');
    Route::post('/shortcourse/module/attached/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@storeModule');
    Route::post('/shortcourse/shortcourse_icdl_module/remove/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@removeModule');

    //SCM - EventParticipant
    Route::get('/event/{id}/events-participants/show', 'ShortCourseManagement\EventManagement\EventParticipantController@show');
    Route::post('/event/{id}/events-participants/data-applicants', 'ShortCourseManagement\EventManagement\EventParticipantController@dataApplicants');
    Route::post('/event/{id}/events-participants/data-no-payment-yet', 'ShortCourseManagement\EventManagement\EventParticipantController@dataNoPaymentYet');
    Route::post('/event/{id}/events-participants/data-payment-wait-for-verification', 'ShortCourseManagement\EventManagement\EventParticipantController@dataPaymentWaitForVerification');
    Route::post('/event/{id}/events-participants/data-ready-for-event', 'ShortCourseManagement\EventManagement\EventParticipantController@dataReadyForEvent');
    Route::post('/event/{id}/events-participants/data-disqualified', 'ShortCourseManagement\EventManagement\EventParticipantController@dataDisqualified');
    Route::post('/event/{id}/events-participants/data-expected-attendances', 'ShortCourseManagement\EventManagement\EventParticipantController@dataExpectedAttendances');
    Route::post('/event/{id}/events-participants/data-attended-participants', 'ShortCourseManagement\EventManagement\EventParticipantController@dataAttendedParticipants');
    Route::post('/event/{id}/events-participants/data-not-attended-participants', 'ShortCourseManagement\EventManagement\EventParticipantController@dataNotAttendedParticipants');
    Route::post('/event/{id}/events-participants/data-participant-post-event', 'ShortCourseManagement\EventManagement\EventParticipantController@dataParticipantPostEvent');
    Route::post('/event/{id}/events-participants/data-completed-participation-process', 'ShortCourseManagement\EventManagement\EventParticipantController@dataCompletedParticipationProcess');
    Route::post('/event/{id}/events-participants/data-not-completed-participation-process', 'ShortCourseManagement\EventManagement\EventParticipantController@dataNotCompletedParticipationProcess');

    //SCM - EventParticipant - Update Progress
    Route::post('/update-progress/{progress_name}/{eventParticipant_id}', 'ShortCourseManagement\EventManagement\EventParticipantController@updateProgress');
    Route::post('/update-progress/bundle', 'ShortCourseManagement\EventManagement\EventParticipantController@updateProgressBundle');

    //SCM - Event
    Route::post('/event/store-new', 'ShortCourseManagement\EventManagement\EventController@storeNew');
    Route::post('/events/data/event-management', 'ShortCourseManagement\EventManagement\EventController@dataEventManagement');
    Route::post('/events/update/{id}', 'ShortCourseManagement\EventManagement\EventController@update');
    Route::post('/events/fee/update/{id}', 'ShortCourseManagement\EventManagement\EventController@updateFee');
    Route::post('/event/fee/create/{id}', 'ShortCourseManagement\EventManagement\EventController@storeFee');
    Route::post('/event/fee/delete/{id}', 'ShortCourseManagement\EventManagement\EventController@deleteFee');
    Route::post('/event/trainer/detached/{id}', 'ShortCourseManagement\EventManagement\EventController@detachedTrainer');
    Route::post('/event/shortcourse/detached/{id}', 'ShortCourseManagement\EventManagement\EventController@detachedShortCourse');
    Route::post('/event/contact_person/attached/{event_id}', 'ShortCourseManagement\EventManagement\EventController@storeContactPerson');
    Route::post('/event/contact_person/detached/{id}', 'ShortCourseManagement\EventManagement\EventController@detachedContactPerson');
    Route::post('/event/trainer/attached/{event_id}', 'ShortCourseManagement\EventManagement\EventController@storeTrainer');
    Route::post('/event/shortcourse/attached/{id}', 'ShortCourseManagement\EventManagement\EventController@storeShortCourse');
    Route::get('/event/create', 'ShortCourseManagement\EventManagement\EventController@create');
    Route::post('/event/delete/{id}', 'ShortCourseManagement\EventManagement\EventController@delete');
    Route::get('/events', 'ShortCourseManagement\EventManagement\EventController@index');
    Route::post('/event', 'ShortCourseManagement\EventManagement\EventController@addEvent');
    Route::get('/event/participant-list/{id}', 'ShortCourseManagement\EventManagement\EventController@participantList')->name('participantList');
    Route::get('/event/report/{id}', 'ShortCourseManagement\EventManagement\EventController@eventReport')->name('event-report');

    Route::get('/event/{event_id}/update-event-status-category/{event_status_category_id}', 'ShortCourseManagement\EventManagement\EventController@updateEventStatus');
    Route::post('/event/updatePoster', 'ShortCourseManagement\EventManagement\EventController@updatePoster')->name('store.poster');
    Route::post('/event/updateSpecificEditor', 'ShortCourseManagement\EventManagement\EventController@updateSpecificEditor')->name('store.specific.editors');
    Route::get('/event/exportApplicantByModule/{event_id}', 'ShortCourseManagement\EventManagement\EventController@exportApplicantByModule')->name('export.applicant.by.module');
    Route::get('/event/{id}', 'ShortCourseManagement\EventManagement\EventController@show');
    Route::delete('/event/{id}', 'ShortCourseManagement\EventManagement\EventController@deleteEvent');
    //SCM - Participant
    // Route::post('/participant/search-by-ic-general/{ic}/show', 'ShortCourseManagement\People\Participant\ParticipantController@searchByIcGeneralShow');

    //SCM - Venue
    Route::get('/venues', 'ShortCourseManagement\Catalogues\Venue\VenueController@index');
    Route::get('/venues/{id}', 'ShortCourseManagement\Catalogues\Venue\VenueController@show');
    Route::post('/venues/data', 'ShortCourseManagement\Catalogues\Venue\VenueController@dataVenues');
    Route::post('/venues/update/{id}', 'ShortCourseManagement\Catalogues\Venue\VenueController@update');
    Route::post('/venue', 'ShortCourseManagement\Catalogues\Venue\VenueController@store');
    Route::post('/venue/delete/{id}', 'ShortCourseManagement\Catalogues\Venue\VenueController@delete');

    //SCM - Feedback
    Route::get('/feedback/form/view/{id}', 'ShortCourseManagement\Feedbacks\FeedbackController@viewForm');
    Route::get('/feedback/form/participant/{event_participant_id}/{sha1_ic}', 'ShortCourseManagement\Feedbacks\FeedbackController@show');
    Route::post('/feedback/form/submit', 'ShortCourseManagement\Feedbacks\FeedbackController@submit');
    Route::get('/feedback/appreciation', 'ShortCourseManagement\Feedbacks\FeedbackController@appreciation');
    Route::get('/feedback-sets', 'ShortCourseManagement\Feedbacks\FeedbackController@index');
    Route::post('/event_feedback_sets/data', 'ShortCourseManagement\Feedbacks\FeedbackController@dataEventFeedbackSet');
    Route::get('/event_feedback_sets/{id}', 'ShortCourseManagement\Feedbacks\FeedbackController@showDetails');
    Route::post('/event_feedback_set/delete/{id}', 'ShortCourseManagement\Feedbacks\FeedbackController@delete');
    Route::post('/event_feedback_sets/update/{id}', 'ShortCourseManagement\Feedbacks\FeedbackController@update');

    //SCM - Topic
    Route::get('/topics', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\TopicController@index');
    Route::get('/topics/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\TopicController@show');
    Route::post('/topics/data', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\TopicController@dataTopics');
    Route::post('/topic/update', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\TopicController@update');
    Route::post('/topic', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\TopicController@store');
    Route::get('/topic/delete/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\TopicController@delete');

    //SCM - Subcategory
    // Route::get('/subcategories', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@index');
    Route::get('/subcategories/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@show');
    Route::post('/subcategories/data', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@dataSubCategories');
    Route::post('/subcategory/update', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@update');
    Route::post('/subcategory', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@store');
    Route::get('/subcategory/delete/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@delete');

    //SCM - Category
    // Route::get('/subcategories', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@index');
    Route::get('/categories/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@show');
    Route::post('/categories/data', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@dataCategories');
    Route::post('/category/update', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@update');
    Route::post('/category', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@store');
    Route::get('/category/delete/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@delete');
});

//SCM - Public View
Route::get('/category/subcategories/{category_id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@getSubCategories');
Route::get('/category/subcategory/topics/{subcategory_id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@getTopics');
Route::get('/participant/search-by-ic/{ic}/event/{event_id}', 'ShortCourseManagement\People\Participant\ParticipantController@searchByIc');

Route::get('/participant/get-hash-ic/{ic}', 'ShortCourseManagement\People\Participant\ParticipantController@hashIc');
Route::post('/event/{event_id}/events-participants/store', 'ShortCourseManagement\EventManagement\EventParticipantController@store');
Route::get('/event/{event_id}/promo-code/{promo_code}/participant', 'ShortCourseManagement\EventManagement\EventParticipantController@applyPromoCode');
Route::get('/event/{event_id}/base-fee', 'ShortCourseManagement\EventManagement\EventParticipantController@baseFee');
Route::get('/participant/search-by-representative-ic/{ic}', 'ShortCourseManagement\People\Participant\ParticipantController@searchByRepresentativeIc');
Route::get('/participant/search-by-ic-general/{sha1_ic}/data', 'ShortCourseManagement\People\Participant\ParticipantController@searchByIcGeneralShow');
Route::get('/participant/search-by-ic-general/{ic}', 'ShortCourseManagement\People\Participant\ParticipantController@searchByIcGeneral');
Route::post('/events/data/event-management/shortcourse/event-participant/{participant_id}', 'ShortCourseManagement\EventManagement\EventParticipantController@dataEventParticipantList');
Route::get('/event-participant/{event_participant_id}/payment_proof', 'ShortCourseManagement\EventManagement\EventParticipantController@showPaymentProof');
Route::post('/event-participant-payment_proof', 'ShortCourseManagement\EventManagement\EventParticipantController@removePaymentProof');

Route::post('/events/data/shortcourse', 'ShortCourseManagement\EventManagement\EventController@dataPublicView');
Route::get('/shortcourse/{id}', 'ShortCourseManagement\EventManagement\EventController@showPublicView');
Route::get('/shortcourse', 'ShortCourseManagement\EventManagement\EventController@indexPublicView');
Route::get('/get-file-event/{filename}', 'ShortCourseManagement\EventManagement\EventController@getFile');
Route::post('/shortcourse/participant/save-payment-proof', 'ShortCourseManagement\EventManagement\EventParticipantController@updatePaymentProof')->name('store.payment_proof');
Route::get('/shortcourse/participant/request-verification/event/{event_id}/participant_id/{participant_id}', 'ShortCourseManagement\EventManagement\EventParticipantController@requestVerification')->name('store.request_verification');
Route::get('/get-payment-proof-image/{id}/{payment_proof_path}', 'ShortCourseManagement\EventManagement\EventParticipantController@getPaymentProofImage');

// Covid19 Public
Route::get('/covid', 'CovidController@openForm')->name('openForm');
Route::get('/findUser', 'CovidController@findUser');
Route::post('openFormStore', 'CovidController@storeOpenForm');
Route::get('/add-form', 'CovidController@addForm');

// Asset Public
Route::get('/asset-search', 'AssetController@assetSearch')->name('assetSearch');
Route::get('get-file-image/{filename}', 'AssetController@getImage');
