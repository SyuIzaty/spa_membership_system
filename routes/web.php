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
    Route::get('home', 'DashboardController@index');

    //eKenderaan
    Route::resource('/eKenderaan-form', 'EKenderaanController');
    Route::post('/eKenderaan-application', 'EKenderaanController@store');
    Route::get('/findStaffID', 'EKenderaanController@findStaffID');
    Route::get('/findStudendID', 'EKenderaanController@findStudID');
    Route::post('/add-passenger', 'EKenderaanController@addPassenger');
    Route::get('/ekenderaan-application', 'EKenderaanController@application');
    Route::post('/get-eKenderaan-list', 'EKenderaanController@getList');
    Route::get('/eKenderaan-list/{id}', 'EKenderaanController@applicationList');
    Route::post('/application-list/{id}', 'EKenderaanController@applicationLists');
    Route::get('/eKenderaan-application/{id}', 'EKenderaanController@show');
    Route::post('/passenger-details/{id}', 'EKenderaanController@passenger');
    Route::post('/hop-hod-reject-application', 'EKenderaanController@rejectApplication');
    Route::post('/hop-hod-verify-application', 'EKenderaanController@verifyApplication');
    Route::post('/operation-reject-application', 'EKenderaanController@operationRejectApplication');
    Route::post('/operation-verify-application', 'EKenderaanController@operationVerifyApplication');
    Route::get('/get-file-attachment/{id}', 'EKenderaanController@file');
    Route::post('/feedback', 'EKenderaanController@feedback');
    Route::get('/eKenderaan-driver', 'EKenderaanController@driver');
    Route::post('/driver-list', 'EKenderaanController@driverList');
    Route::post('/add-driver', 'EKenderaanController@addDriver');
    Route::post('/edit-driver', 'EKenderaanController@editDriver');
    Route::get('/eKenderaan-vehicle', 'EKenderaanController@vehicle');
    Route::post('/vehicle-list', 'EKenderaanController@vehicleList');
    Route::post('/add-vehicle', 'EKenderaanController@addVehicle');
    Route::post('/edit-vehicle', 'EKenderaanController@editVehicle');
    Route::get('/ekn-report', 'EKenderaanController@report');
    Route::post('/all-report-ekn', 'EKenderaanController@allReport');
    Route::get('/get-year-ekn/{year}', 'EKenderaanController@getYear');
    Route::post('/year-report-ekn', 'EKenderaanController@reportYear');
    Route::post('/month-year-report-ekn', 'EKenderaanController@reportMonthYear');
    Route::get('/eKenderaan-Reports', 'EKenderaanController@eKenderaanReport');
    Route::get('/eKenderaan-Report-Year/{year}', 'EKenderaanController@eKenderaanReportYear');
    Route::get('/eKenderaan-Report-Year-Month/{year}/{month}', 'EKenderaanController@eKenderaanReportYearMonth');
    Route::get('/log-eKenderaan/{id}', 'EKenderaanController@log');
    Route::post('/log-eKenderaan-list/{id}', 'EKenderaanController@logList');
    Route::get('/student-list-excel-format', 'EKenderaanController@getFile');
    Route::post('/review-application', 'EKenderaanController@review');
    Route::get('/temp-file/{id}', 'EKenderaanController@getTempFile');
    Route::delete('/cancel-application/{id}', 'EKenderaanController@cancelApplication');
    Route::get('/eKenderaan-feedback-questions', 'EKenderaanController@question');
    Route::post('/feedback-questions', 'EKenderaanController@questionList');
    Route::post('/add-feedback-questions', 'EKenderaanController@addQuestion');
    Route::post('/edit-feedback-questions', 'EKenderaanController@editQuestion');
    Route::post('/assign-driver/{id}', 'EKenderaanController@assignDriver');
    Route::delete('/delete-assign-driver/{id}', 'EKenderaanController@deleteAssignedDriver');
    Route::post('/assign-vehicle/{id}', 'EKenderaanController@assignVehicle');
    Route::delete('/delete-assign-vehicle/{id}', 'EKenderaanController@deleteAssignedVehicle');
    Route::post('/assign-new-vehicle', 'EKenderaanController@assignNewVehicle');
    Route::post('/assign-new-driver', 'EKenderaanController@assignNewDriver');
    Route::post('/edit-assign-vehicle', 'EKenderaanController@updateAssignedVehicle');
    Route::get('/ekn-driver-report', 'EKenderaanController@driverReportList');
    Route::post('/get-ekn-driver-report', 'EKenderaanController@getDriverReportList');
    Route::get('/view-driver-report/{id}', 'EKenderaanController@viewDriverReport');
    Route::get('/report-driver-pdf/{id}', 'EKenderaanController@DriverReportPDF');
    Route::get('/get-year-driver/{year}', 'EKenderaanController@getYearDriver');
    Route::get('/view-driver-report/{year}/{id}', 'EKenderaanController@viewDriverReportYear');
    Route::get('/report-driver-pdf/{year}/{id}', 'EKenderaanController@DriverReportPDFYear');
    Route::get('/view-driver-report/{year}/{month}/{id}', 'EKenderaanController@viewDriverReportYearMonth');
    Route::get('/report-driver-pdf/{year}/{month}/{id}', 'EKenderaanController@DriverReportPDFYearMonth');
    Route::post('request-cancellation', 'EKenderaanController@operationCancelApplication');




    // Aduan
    Route::get('/borang-aduan', 'Aduan\AduanController@borangAduan')->name('borangAduan');
    Route::post('simpanAduan', 'Aduan\AduanController@simpanAduan');
    Route::get('/cariJenis', 'Aduan\AduanController@cariJenis');
    Route::get('/cariSebab', 'Aduan\AduanController@cariSebab');
    Route::get('/aduan', 'Aduan\AduanController@aduan')->name('aduan');
    Route::post('data_aduan', 'Aduan\AduanController@data_aduan');
    Route::post('batalAduan', 'Aduan\AduanController@batalAduan');
    Route::get('/maklumat-aduan/{id}', 'Aduan\AduanController@maklumatAduan')->name('maklumatAduan');
    Route::get('resit/{filename}/{type}', 'Aduan\AduanController@failResit');
    Route::get('get-file-resit/{filename}', 'Aduan\AduanController@getImej');
    Route::post('simpanPengesahan', 'Aduan\AduanController@simpanPengesahan');
    Route::post('kemaskiniTahap', 'Aduan\AduanController@kemaskiniTahap');
    Route::get('padamAlatan/{id}/{id_aduan}', 'Aduan\AduanController@padamAlatan')->name('padamAlatan');
    Route::get('padamJuruteknik/{id}/{id_aduan}', 'Aduan\AduanController@padamJuruteknik')->name('padamJuruteknik');
    Route::post('tukarStatus', 'Aduan\AduanController@tukarStatus');
    Route::get('get-file-gambar/{filename}', 'Aduan\AduanController@getGambar');
    Route::get('/senarai-aduan', 'Aduan\AduanController@senaraiAduan')->name('senarai');
    Route::post('senaraiAduan', 'Aduan\AduanController@data_senarai');
    // Route::post('updateJuruteknik', 'Aduan\AduanController@updateJuruteknik');
    // Route::delete('senarai-aduan/{id}', 'Aduan\AduanController@padamAduan');
    Route::get('/info-aduan/{id}', 'Aduan\AduanController@infoAduan')->name('info');
    // Route::post('simpanPenambahbaikan', 'Aduan\AduanController@simpanPenambahbaikan');
    Route::post('kemaskiniPenambahbaikan', 'Aduan\AduanController@kemaskiniPenambahbaikan');
    Route::post('simpanStatus', 'Aduan\AduanController@simpanStatus');
    Route::get('/senarai-selesai', 'Aduan\AduanController@senaraiSelesai')->name('selesai');
    Route::post('senaraiSelesai', 'Aduan\AduanController@data_selesai');
    Route::get('/senarai-kiv', 'Aduan\AduanController@senaraiKiv')->name('kiv');
    Route::post('senaraiKiv', 'Aduan\AduanController@data_kiv');
    Route::get('/senarai-bertindih', 'Aduan\AduanController@senaraiBertindih')->name('bertindih');
    Route::post('senaraiBertindih', 'Aduan\AduanController@data_bertindih');
    Route::get('/pdfAduan/{id}', 'Aduan\AduanController@pdfAduan')->name('pdfAduan');
    Route::get('/export_aduan', 'Aduan\AduanController@aduan_all')->name('exportAduan');
    Route::get('/export_aduan_staf', 'Aduan\AduanController@aduan_all_staff')->name('exportAduanStaf');
    Route::post('/data_aduanexport', 'Aduan\AduanController@data_aduanexport');
    Route::get('/aduanExport', 'Aduan\AduanController@aduans');
    Route::post('/aduanExport', 'Aduan\AduanController@aduans');
    Route::get('exportaduan/{kategori?}/{status?}/{tahap?}/{bulan?}', 'Aduan\AduanController@aduans');
    Route::get('/juruExport/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'Aduan\AduanController@jurutekniks');
    Route::post('/juruExport/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'Aduan\AduanController@jurutekniks');
    Route::get('juruaduan/{juruteknik?}/{stat?}/{kate?}/{bul?}', 'Aduan\AduanController@jurutekniks');
    Route::get('/individuExport/{stats?}/{kates?}/{buls?}', 'Aduan\AduanController@individu');
    Route::post('/individuExport/{stats?}/{kates?}/{buls?}', 'Aduan\AduanController@individu');
    Route::get('aduanIndividu/{stats?}/{kates?}/{buls?}', 'Aduan\AduanController@individu');
    Route::get('/dashboard-aduan', 'Aduan\AduanController@index');
    Route::get('/download/{id}', 'Aduan\AduanController@downloadBorang')->name('downloadBorang');
    Route::get('pembaikan/{filename}/{type}', 'Aduan\AduanController@failPembaikan');
    Route::get('padamGambar/{id}/{id_aduan}', 'Aduan\AduanController@padamGambar')->name('padamGambar');

    // Kategori
    Route::resource('kategori-aduan', 'Aduan\KategoriAduanController');
    Route::post('kategoriAduan', 'Aduan\KategoriAduanController@data_kategori');
    Route::post('tambahKategori', 'Aduan\KategoriAduanController@tambahKategori');
    Route::post('kemaskiniKategori', 'Aduan\KategoriAduanController@kemaskiniKategori');

    // Jenis
    Route::resource('jenis-kerosakan', 'Aduan\JenisKerosakanController');
    Route::post('jenisKerosakan', 'Aduan\JenisKerosakanController@data_jenis');
    Route::post('tambahJenis', 'Aduan\JenisKerosakanController@tambahJenis');
    Route::post('kemaskiniJenis', 'Aduan\JenisKerosakanController@kemaskiniJenis');

    // Sebab
    Route::resource('sebab-kerosakan', 'Aduan\SebabKerosakanController');
    Route::post('sebabKerosakan', 'Aduan\SebabKerosakanController@data_sebab');
    Route::post('tambahSebab', 'Aduan\SebabKerosakanController@tambahSebab');
    Route::post('kemaskiniSebab', 'Aduan\SebabKerosakanController@kemaskiniSebab');

    // Alat
    Route::resource('alat-ganti', 'Aduan\AlatGantiController');
    Route::post('alatGanti', 'Aduan\AlatGantiController@data_alat');
    Route::post('tambahAlat', 'Aduan\AlatGantiController@tambahAlat');
    Route::post('kemaskiniALat', 'Aduan\AlatGantiController@kemaskiniALat');

    // AssetType
    Route::resource('asset-type', 'AssetTypeController');
    Route::post('assetType', 'AssetTypeController@data_asset');
    Route::post('addType', 'AssetTypeController@addType');
    Route::post('updateType', 'AssetTypeController@updateType');

    // AssetClass
    Route::resource('asset-class', 'AssetClassController');
    Route::post('assetClass', 'AssetClassController@data_asset_class');
    Route::post('addClass', 'AssetClassController@addClass');
    Route::post('updateClass', 'AssetClassController@updateCLass');

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
    Route::get('exportasset/{availability?}/{type?}/{status?}/{classs?}', 'AssetController@exports');
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
    Route::post('import-asset', 'AssetController@importAsset');
    Route::get('/assetTemplates', 'AssetController@assetTemplate');
    Route::get('/asset-trail/{id}', 'AssetController@assetTrail');
    Route::get('/asset-dashboard', 'AssetController@dashboard');
    Route::post('printBarcode', 'AssetController@printBarcode');

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
    Route::get('/stockTemplate', 'StockController@stockTemplate');
    Route::post('store-bulk-stock', 'StockController@bulkStockStore');
    Route::get('/transactionTemplate', 'StockController@transactionTemplate');
    Route::post('store-bulk-transaction', 'StockController@bulkTransactionStore');
    Route::post('upload-stock-image', 'StockController@uploadImages');

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
    Route::get('/declareNew', 'CovidController@new')->name('new');
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
    Route::get('/covid-dashboard', 'CovidController@dashboard');

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
    Route::post('/shortcourse/event_module/remove/{id}', 'ShortCourseManagement\Catalogues\ShortCourse\ShortCourseController@removeModule');

    //SCM - EventParticipant
    Route::get('/event/{id}/events-participants/show', 'ShortCourseManagement\EventManagement\EventParticipantController@show');
    Route::post('/event/{id}/events-participants/data-applicants', 'ShortCourseManagement\EventManagement\EventParticipantController@dataApplicants');
    Route::post('/event/{id}/events-participants/data-all-applicant', 'ShortCourseManagement\EventManagement\EventParticipantController@dataAllApplicant');
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
    Route::post('/events/module/update', 'ShortCourseManagement\EventManagement\EventController@eventModuleUpdate');
    Route::post('/event/event_module/remove/{id}', 'ShortCourseManagement\EventManagement\EventController@removeModule');
    Route::post('/event/module/attached/{id}', 'ShortCourseManagement\EventManagement\EventController@storeModule');

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
    // Route::get('/subcategories/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@show');
    Route::post('/subcategories/data', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@dataSubCategories');
    Route::post('/subcategory/update', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@update');
    Route::post('/subcategory', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@store');
    Route::get('/subcategory/delete/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@delete');

    //SCM - Category
    // Route::get('/subcategories', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@index');
    // Route::get('/categories/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@show');
    Route::post('/categories/data', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@dataCategories');
    Route::post('/category/update', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@update');
    Route::post('/category', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@store');
    Route::get('/category/delete/{id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@delete');

    // Computer Grant Management
    Route::get('/application-form', 'ComputerGrantController@index');
    Route::get('/all-grant-list/{id}', 'ComputerGrantController@allGrantList');
    Route::get('/grant-list', 'ComputerGrantController@grantList');
    Route::post('store-application', 'ComputerGrantController@store');
    Route::post('/datalist', 'ComputerGrantController@datalist');
    Route::post('/alldatalist/{id}', 'ComputerGrantController@allDataLists');
    Route::get('/application-detail/{id}', 'ComputerGrantController@applicationDetail');
    Route::get('/view-application-detail/{id}', 'ComputerGrantController@viewApplicationDetail');
    Route::post('/update-application', 'ComputerGrantController@update');
    Route::post('/verify-application', 'ComputerGrantController@verifyApplication');
    Route::post('/verify-purchase', 'ComputerGrantController@verifyPurchase');
    Route::post('reject-purchase', 'ComputerGrantController@rejectPurchase');
    Route::post('/verify-reimbursement', 'ComputerGrantController@verifyReimbursement');
    Route::post('/cancel-reimbursement', 'ComputerGrantController@undoReimbursement');
    Route::get('get-receipt/{receipt}', 'ComputerGrantController@getReceipt');
    Route::get('get-image/{image}', 'ComputerGrantController@getImage');
    Route::get('get-file/{file}', 'ComputerGrantController@getFile');
    Route::get('get-declaration/{id}', 'ComputerGrantController@getDeclarationFile');
    Route::get('Grant-Reimbursement-Form', 'ComputerGrantController@getFinanceForm');
    Route::get('Grant-System-Flow-Chart', 'ComputerGrantController@getSystemFlowchart');
    Route::get('/applicationPDF/{id}', 'ComputerGrantController@applicationPDF');
    Route::get('/faq', 'ComputerGrantController@faq');
    Route::get('/faq-list', 'ComputerGrantController@faqList');
    Route::post('/getFAQ', 'ComputerGrantController@getFAQ');
    Route::post('/add-FAQ', 'ComputerGrantController@addFAQ');
    Route::post('/edit-FAQ', 'ComputerGrantController@editFAQ');
    Route::get('/log-computer-grant/{id}', 'ComputerGrantController@log');
    Route::post('/loglist/{id}', 'ComputerGrantController@logList');
    Route::get('/all-log', 'ComputerGrantController@allLog');
    Route::post('/allloglist', 'ComputerGrantController@allLogList');
    Route::post('/getQuota', 'ComputerGrantController@quota');
    Route::get('/quota-list', 'ComputerGrantController@quotaList');
    Route::post('/add-quota', 'ComputerGrantController@addQuota');
    Route::post('/edit-quota', 'ComputerGrantController@editQuota');
    Route::delete('/delete-faq/{id}', 'ComputerGrantController@deleteFAQ');
    Route::get('/agreementPDF/{id}', 'ComputerGrantController@agreementPDF');
    Route::post('/declaration', 'ComputerGrantController@declaration');
    Route::post('/upload-declaration', 'ComputerGrantController@uploadAgreement');
    Route::post('requestCancellation', 'ComputerGrantController@requestCancellation');
    Route::post('/verifyCancellation', 'ComputerGrantController@verifyCancellation');
    Route::post('cancel-application', 'ComputerGrantController@cancelApplication');
    Route::get('/report/{all}', 'ComputerGrantController@report');
    Route::post('/reportList/{all}', 'ComputerGrantController@reportList');
    Route::get('/report/{month}', 'ComputerGrantController@reportbyMonth');
    Route::get('/Computer-Grant-Report-{my}', 'ComputerGrantController@getReportbyMonth');
    Route::get('/Computer-Grant-Report', 'ComputerGrantController@getReport');

    //Engagement Management System
    Route::get('/list/{id}', 'EngagementManagementController@index');
    Route::post('/all-list/{id}', 'EngagementManagementController@lists');
    Route::get('/create', 'EngagementManagementController@new');
    Route::post('/post-create', 'EngagementManagementController@store');
    Route::post('/todolist-create', 'EngagementManagementController@createToDoList');
    Route::post('/todolist-update', 'EngagementManagementController@updateToDoList');
    Route::post('/update-profile', 'EngagementManagementController@updateProfile');
    Route::delete('/delete-member/{id}', 'EngagementManagementController@deleteMember');
    Route::post('/create-progress', 'EngagementManagementController@createProgress');
    Route::post('/getProgress/{id}', 'EngagementManagementController@getProgress');
    Route::post('/edit-progress', 'EngagementManagementController@editProgress');
    Route::get('/status', 'EngagementManagementController@status');
    Route::post('/getStatus', 'EngagementManagementController@getStatus');
    Route::post('/add-status', 'EngagementManagementController@addStatus');
    Route::post('/edit-status', 'EngagementManagementController@editStatus');
    Route::get('/engagement-detail/{id}', 'EngagementManagementController@details');
    Route::delete('/delete-status/{id}', 'EngagementManagementController@deleteStatus');
    Route::delete('/delete-todolist/{id}', 'EngagementManagementController@deleteToDoList');
    Route::get('/new-progress/{id}', 'EngagementManagementController@newProgress');
    Route::get('/edit-progress/{id}', 'EngagementManagementController@progress');
    Route::post('/store-files', 'EngagementManagementController@storeFile');
    Route::get('get-uploaded-file/{file}', 'EngagementManagementController@getFile');
    Route::delete('/delete-file/{id}', 'EngagementManagementController@deleteFile');
    Route::delete('/delete-progress/{id}', 'EngagementManagementController@deleteProgress');

    //eDocument Management System
    Route::resource('/index', 'DocumentManagementController');
    Route::get('get-doc/{file}', 'DocumentManagementController@getDoc');
    Route::get('upload', 'DocumentManagementController@upload');
    Route::get('upload/{id}', 'DocumentManagementController@getUpload');
    Route::post('/store-doc', 'DocumentManagementController@storeDoc');
    Route::delete('/delete-doc/{id}', 'DocumentManagementController@deleteDoc');
    Route::post('/update-title', 'DocumentManagementController@updateTitle');
    Route::post('/edit', 'DocumentManagementController@edit');
    Route::get('department-list', 'DocumentManagementController@departmentList');
    Route::post('/getDeptList', 'DocumentManagementController@getDepartment');
    Route::get('update-admin/{id}', 'DocumentManagementController@adminList');
    Route::delete('destroy/{id}', 'DocumentManagementController@destroy')->name('destroy');
    Route::post('/store', 'DocumentManagementController@store');

    //eAduan Korporat
    Route::get('/lists/{id}', 'AduanKorporatController@list');
    Route::post('/get-list/{id}', 'AduanKorporatController@show');
    Route::get('/detail/{id}', 'AduanKorporatController@detail');
    Route::post('/get-department', 'AduanKorporatController@getDept');
    Route::post('/assign-department', 'AduanKorporatController@assign');
    Route::post('/submit-remark', 'AduanKorporatController@remark');
    Route::post('/submit-complete', 'AduanKorporatController@complete');
    Route::get('/log/{id}', 'AduanKorporatController@log');
    Route::post('/get-log/{id}', 'AduanKorporatController@logList');
    Route::post('/change-dept', 'AduanKorporatController@changeDepartment');
    Route::get('/dashboard-icomplaint', 'AduanKorporatController@dashboard');
    Route::get('/searchYear/{year}', 'AduanKorporatController@searchYear');
    Route::get('/searchMonth/{month}', 'AduanKorporatController@searchMonth');
    Route::get('/reports', 'AduanKorporatController@reports');
    Route::post('/all-report', 'AduanKorporatController@allReport');
    Route::get('/get-year/{year}', 'AduanKorporatController@getYear');
    Route::post('/year-month-report', 'AduanKorporatController@getReport');
    Route::post('/year-report', 'AduanKorporatController@getReportYear');
    Route::post('/year-month-dashboard', 'AduanKorporatController@getDashboard');
    Route::get('/admin-list', 'AduanKorporatController@admin');
    Route::post('/departmentList', 'AduanKorporatController@departmentLists');
    Route::get('/admin-list/{id}', 'AduanKorporatController@adminList');
    Route::post('/store-admin', 'AduanKorporatController@storeAdmin');
    Route::delete('/delete-admin/{id}', 'AduanKorporatController@deleteAdmin');
    Route::get('/status-list', 'AduanKorporatController@status');
    Route::post('/get-status-list', 'AduanKorporatController@getStatus');
    Route::post('/store-status', 'AduanKorporatController@addStatus');
    Route::post('/update-status', 'AduanKorporatController@updateStatus');
    Route::delete('/delete-status/{id}', 'AduanKorporatController@destroyStatus');
    Route::get('category-lists', 'AduanKorporatController@category');
    Route::post('/get-category-list', 'AduanKorporatController@getCategory');
    Route::post('/storeCategories', 'AduanKorporatController@addCategory');
    Route::post('/update-categories', 'AduanKorporatController@updateCategory');
    Route::delete('/delete-categories/{id}', 'AduanKorporatController@destroyCategory');
    Route::get('user-category-list', 'AduanKorporatController@userCategory');
    Route::post('get-usercategory-list', 'AduanKorporatController@getUserCategory');
    Route::post('/store-usercategory', 'AduanKorporatController@addUserCategory');
    Route::post('/update-usercategory', 'AduanKorporatController@updateUserCategory');
    Route::delete('/delete-usercategory/{id}', 'AduanKorporatController@destroyUserCategory');
    Route::get('subcategory-list', 'AduanKorporatController@subCategory');
    Route::post('/getSubCat', 'AduanKorporatController@getSubCat');
    Route::post('/addSubCat', 'AduanKorporatController@addSubCategory');
    Route::post('/editSubCat', 'AduanKorporatController@editSubCategory');
    Route::get('/iComplaint-Reports', 'AduanKorporatController@iComplaintReport');
    Route::get('/iComplaint-Report-Year/{year}', 'AduanKorporatController@iComplaintReportYear');
    Route::get('/iComplaint-Report-Year-Month/{year}/{month}', 'AduanKorporatController@iComplaintReportYearMonth');

    // Training : Training
    Route::get('/training-list', 'TrainingController@trainingList');
    Route::post('data-training', 'TrainingController@data_training');
    Route::post('store-training', 'TrainingController@storeTraining');
    Route::post('update-training', 'TrainingController@updateTraining');
    Route::delete('delete-training/{id}', 'TrainingController@deleteTraining')->name('deleteTraining');
    Route::get('/training-info/{id}', 'TrainingController@trainingInfo');
    Route::get('/training-pdf/{id}', 'TrainingController@trainingPdf');
    Route::get('/training-evaluation/{id}/{staff}', 'TrainingController@trainingEvaluation');

    // Training : Type
    Route::get('/type-list', 'TrainingController@typeList');
    Route::post('data-type', 'TrainingController@data_type');
    Route::post('store-type', 'TrainingController@storeType');
    Route::post('update-type', 'TrainingController@updateType');
    Route::delete('delete-type/{id}', 'TrainingController@deleteType')->name('deleteType');

    // Training : Category
    Route::get('/category-list', 'TrainingController@categoryList');
    Route::post('data-category', 'TrainingController@data_category');
    Route::post('store-category', 'TrainingController@storeCategory');
    Route::post('update-category', 'TrainingController@updateCategory');
    Route::delete('delete-category/{id}', 'TrainingController@deleteCategory')->name('deleteCategory');

    // Training : Hour
    Route::get('/hour-list', 'TrainingController@hourList')->name('hourList');
    Route::post('data-hour', 'TrainingController@data_hour');
    Route::post('store-hour', 'TrainingController@storeHour');
    Route::post('update-hour', 'TrainingController@updateHour');
    Route::delete('delete-hour/{id}', 'TrainingController@deleteHour')->name('deleteHour');
    Route::post('assign-hour/{id}', 'TrainingController@assignHour');
    Route::post('assign-hour-individual', 'TrainingController@assignHourIndividual');
    Route::get('/findStaff', 'TrainingController@findStaff');

    // Training : Claim
    Route::get('/claim-form', 'TrainingController@claimForm');
    Route::post('store-claim', 'TrainingController@claimStore')->name('claimStore');
    Route::get('/claim-list', 'TrainingController@claimList')->name('claimList');
    Route::post('data-pending-claim', 'TrainingController@data_pending_claim');
    Route::post('approve-claim', 'TrainingController@approveClaim');
    Route::post('reject-claim', 'TrainingController@rejectClaim');
    Route::post('/get-attachment', 'TrainingController@getAttachment');
    Route::get('getClaimAttachment/{id}', 'TrainingController@getClaimAttachment');
    Route::delete('delete-claim/{id}', 'TrainingController@deleteClaim')->name('deleteClaim');
    Route::get('/claim-info/{id}', 'TrainingController@claimInfo');
    Route::get('claim/{filename}/{type}', 'TrainingController@claimAttachment');
    Route::post('data-approve-claim', 'TrainingController@data_approve_claim');
    Route::post('data-reject-claim', 'TrainingController@data_reject_claim');
    Route::get('/claim-record', 'TrainingController@claimRecord')->name('claimRecord');
    Route::get('/claim-slip/{id?}/{year?}/{type?}', 'TrainingController@claimSlip');
    Route::get('/export-claim', 'TrainingController@exportClaim');
    Route::get('/export-latest-claim/{year?}', 'TrainingController@exportLatestClaim');
    Route::get('/findTraining', 'TrainingController@findTraining');
    Route::post('store-file', 'TrainingController@fileStore');
    Route::post('delete-file', 'TrainingController@fileDestroy');
    Route::get('deleteFile/{id}', 'TrainingController@deleteFile')->name('deleteFile');

    // Training : Bulk Claim
    Route::get('/bulk-claim-form', 'TrainingController@bulkClaimForm');
    Route::post('store-bulk-claim', 'TrainingController@bulkClaimStore');
    Route::get('/bulkClaimTemplate', 'TrainingController@bulkClaimTemplate');

    // Training : Record
    Route::get('/claim-all-slip/{id?}/{year?}', 'TrainingController@claimAll');
    Route::get('/record-staff', 'TrainingController@recordStaff');
    Route::post('data-record-staff', 'TrainingController@data_record_staff');
    Route::get('/record-info/{id}', 'TrainingController@recordInfo')->name('recordInfo');
    Route::get('/export-latest-record', 'TrainingController@exportLatestRecord');
    Route::get('/export-record', 'TrainingController@exportRecord');

    // Training : Evaluation
    Route::get('/evaluation-question', 'TrainingController@questionList');
    Route::post('data-evaluation', 'TrainingController@data_evaluation');
    Route::post('store-evaluation', 'TrainingController@storeEvaluation');
    Route::post('update-evaluation', 'TrainingController@updateEvaluation');
    Route::delete('delete-evaluation/{id}', 'TrainingController@deleteEvaluation')->name('deleteEvaluation');
    Route::get('/question-info/{id}', 'TrainingController@questionInfo');
    Route::post('store-question-header', 'TrainingController@storeHeader')->name('storeHeader');
    Route::post('update-question-header', 'TrainingController@updateHeader')->name('updateHeader');
    Route::post('reorder-question-header', 'TrainingController@reorderHeader')->name('reorderHeader');
    Route::post('store-question', 'TrainingController@storeQuestion')->name('storeQuestion');
    Route::post('update-question', 'TrainingController@updateQuestion')->name('updateQuestion');
    Route::post('reorder-question', 'TrainingController@reorderQuestion')->name('reorderQuestion');
    Route::get('/question-pdf/{id}', 'TrainingController@questionPdf')->name('questionPdf');

    // Training : Evaluation Report
    Route::get('/evaluation-report', 'TrainingController@reportList');
    Route::post('data-evaluation-report', 'TrainingController@data_evaluation_report');
    Route::get('/report-info/{id}', 'TrainingController@reportInfo');
    Route::get('/report-response/{id}/{head}/{eval}', 'TrainingController@reportResponse');
    Route::get('/report-response-pdf/{id}/{head}/{eval}', 'TrainingController@reportResponsePdf')->name('reportResponsePdf');
    Route::get('/report-pdf/{id}', 'TrainingController@reportPdf');

    // Training : Evaluation Form
    Route::get('/evaluation-form/{id}', 'TrainingController@evaluationForm');
    Route::post('store-evaluation-form', 'TrainingController@storeEvaluationForm');
    Route::post('update-evaluation-form', 'TrainingController@updateEvaluationForm');

    // Training : Dashboard
    Route::get('/training-dashboard', 'TrainingController@dashboard')->name('dashList');


    // eVotingController
    Route::get('/candidate-relevant', 'API\eVoting\CandidateController@getCandidateRelevant');
    Route::post('/candidate-relevant/vote', 'API\eVoting\VoteController@store');
    Route::post('/candidate-relevant/update', 'API\eVoting\CandidateController@update');
    Route::post('/candidate-relevant/add', 'API\eVoting\CandidateController@store');
    Route::delete('/candidate-relevant/{student_id}/{voting_session_id}', 'API\eVoting\CandidateController@destroy');
    Route::delete(
        '/candidate-category-programme-category/{candidate_category_id}/{programme_category_id}',
        'API\eVoting\CandidateCategoryProgrammeCategoryController@destroy'
    );
    Route::get('/vote-status', 'API\eVoting\VoteController@voteStatus');
    Route::get('/categorical-statistics', 'API\eVoting\VoteController@categoricalStatistics');
    Route::get('/categorical-report/{voting_session_id}', 'API\eVoting\VoteController@categoricalReport');
    Route::get('/overall-report/{voting_session_id}', 'API\eVoting\VoteController@overallReport');
    Route::get('/get-candidate-image', 'API\eVoting\CandidateController@getCandidateImage');
    Route::get('/vote-is-open', 'API\eVoting\VoteController@getVoteIsOpen');
    Route::get('/vote-sessions', 'API\eVoting\VoteController@getVoteSessions');
    Route::get('/vote-sessions/{id}', 'API\eVoting\VoteController@getVoteSessionDetails');
    Route::get('/students/{id}', 'API\StudentController@show');
    Route::post('/e-voting/programmes/{programme_id}', 'API\eVoting\ProgrammeController@update');
    Route::get('/e-voting/programmes', 'API\eVoting\ProgrammeController@index');
    Route::get('/e-voting/programme-categories', 'API\eVoting\ProgrammeCategoryController@index');
    Route::post('/e-voting/candidate-category', 'API\eVoting\CandidateCategoryController@store');
    Route::post('/e-voting/candidate-category/{id}', 'API\eVoting\CandidateCategoryController@update');
    Route::delete('/e-voting/candidate-category/{id}', 'API\eVoting\CandidateCategoryController@destroy');

    Route::post('/e-voting/candidate-categories-programme-categories', 'API\eVoting\CandidateCategoryProgrammeCategoryController@update');
    Route::post('/e-voting/session/{session_id}', 'API\eVoting\SessionController@update');
    Route::post('/e-voting/session', 'API\eVoting\SessionController@store');


    Route::get('/vote-platform', function () {
        return view('e-voting/platform');
    });

    Route::get('/vote-report', function () {
        return view('e-voting/report');
    });


    Route::get('/vote-management', function () {
        return view('e-voting/management');
    });

    Route::get('/vote-platform/{vue_capture?}', function () {
        return view('e-voting/platform');
    })->where('vue_capture', '[\/\w\.-]*');

    Route::get('/vote-report/{vue_capture?}', function () {
        return view('e-voting/report');
    })->where('vue_capture', '[\/\w\.-]*');

    Route::get('/vote-management/{vue_capture?}', function () {
        return view('e-voting/management');
    })->where('vue_capture', '[\/\w\.-]*');
});

//SCM - Public View
Route::get('/category/subcategories/{category_id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\CategoryController@getSubCategories');
Route::get('/category/subcategory/topics/{subcategory_id}', 'ShortCourseManagement\Catalogues\TopicSubCategoryCategory\SubCategoryController@getTopics');
Route::get('/participant/search-by-ic/{ic}/event/{event_id}', 'ShortCourseManagement\People\Participant\ParticipantController@searchByIc');

Route::get('/feedback/form/participant/{event_participant_id}/{sha1_ic}', 'ShortCourseManagement\Feedbacks\FeedbackController@show');

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
Route::get('/event-participant/print-certificate/{id}', 'ShortCourseManagement\EventManagement\EventParticipantController@printCertificate');
Route::get('/get-certificate-background', 'ShortCourseManagement\EventManagement\EventParticipantController@getCertificateBackground');

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
Route::get('/covid-result', 'CovidController@addForm');

// Asset Public
Route::get('/asset-search', 'AssetController@assetSearch')->name('assetSearch');
Route::get('get-file-image/{filename}', 'AssetController@getImage');

// Training : Open Attendance - Public
Route::get('/training-open-attendance/{id}', 'TrainingController@openAttendance')->name('openAttendance');
Route::post('training-confirm-attendance', 'TrainingController@confirmAttendance');
Route::get('get-train-image/{filename}', 'TrainingController@getImage');

// eAduan Korporat Public
Route::get('/form', 'AduanKorporatController@index');
Route::get('/iComplaint', 'AduanKorporatController@main');
Route::get('/end/{ticket}', 'AduanKorporatController@end');
Route::get('/check', 'AduanKorporatController@check');
Route::get('/search', 'AduanKorporatController@search');
Route::post('/store', 'AduanKorporatController@store');
Route::get('/searchID', 'AduanKorporatController@searchID');
Route::get('/detail', 'AduanKorporatController@displayDetail');
Route::get('/lists', 'AduanKorporatController@publicList');
Route::post('/get-lists/{id}', 'AduanKorporatController@getPublicList');
Route::get('/view-detail/{id}', 'AduanKorporatController@publicDetail');
Route::get('/get-files/{id}', 'AduanKorporatController@file');
