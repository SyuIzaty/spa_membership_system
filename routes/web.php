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
Route::resource('applicant','ApplicantController');
Route::get('/applicant','ApplicantController@create');

Route::resource('student', 'StudentController');
Route::resource('course', 'CourseController');
Route::resource('admin/campus', 'CampusController');
Route::resource('admin/semester', 'SemesterController');
Route::resource('admin/admission/application', 'ApplicantController');

//SPACE
Route::resource('space/campus', 'CampusController'); //campus
Route::resource('space/zone', 'ZoneController');  //zone
Route::resource('space/building', 'BuildingController');  //building
Route::get('/findzoneid', 'BuildingController@findzoneid'); //dropdown building
Route::get('/findzone', 'LevelController@findzone'); //dropdown level
Route::get('/findbuilding', 'LevelController@findbuilding'); //dropdown level
Route::get('/findroomsuitability', 'RoomFacilityController@findroomsuitability'); //dropdown suitability
Route::resource('space/level', 'LevelController');  //level
Route::resource('space/roomtype', 'RoomTypeController');  //roomtype
Route::resource('space/roomsuitability', 'RoomSuitabilityController');  //roomsuitability
Route::resource('space/roomfacility', 'RoomFacilityController');  //roomfacility
Route::resource('space/roomowner', 'RoomOwnerController');  //roomowner

//APPLICANTS

Route::post('/display', 'ApplicantController@checkIndividual')->name('checkIndividual');
Route::post('/qualifiedProgramme', 'ApplicantController@qualifiedProgramme')->name('qualifiedProgramme');
Route::get('/applicantresult','ApplicantController@indexs');
Route::get('/incomplete','ApplicantController@applicant_incomplete');
Route::get('/passapplicant','ApplicantController@applicant_pass');
Route::get('/failapplicant','ApplicantController@applicant_fail');
Route::get('/offerapplicant','ApplicantController@applicant_offer');
Route::get('/publishedoffer','ApplicantController@applicant_published');
Route::get('/applicantupdatestat', 'ApplicantController@applicant_updatestat');
Route::get('checkrequirements', 'ApplicantController@checkrequirements')->name('check-requirements');
Route::get('checkindividual', 'ApplicantController@checkindividual')->name('check-individual');
Route::post('changestatus', 'ApplicantController@changestatus');
Route::get('offeredprogramme', 'ApplicantController@offeredprogramme')->middleware('can:email offer letter');
Route::post('applicantstatus', 'ApplicantController@applicantstatus');
Route::post('intakestatus', 'ApplicantController@intakestatus');
Route::post('cancelOffer', 'ApplicantController@cancelOffer');
Route::post('appstat', 'ApplicantController@appstat');
Route::post('updateEmergency', 'ApplicantController@updateEmergency');
Route::post('updateGuardian', 'ApplicantController@updateGuardian');
Route::post('updateApplicant', 'ApplicantController@updateApplicant');
Route::post('/applicant-check', 'ApplicantController@applicantcheck')->name('applicant-check');
Route::get('/sponsorapplicant', 'ApplicantController@sponsorapplicant');
Route::post('sendupdateApplicant', 'ApplicantController@sendupdateApplicant');
Route::get('/sponsorTemplate','ApplicantController@sponsorTemplate');
Route::get('firstreminder', 'ApplicantController@firstReminder')->name('first-reminder');
Route::get('jpareminder', 'ApplicantController@jpaReminder')->name('jpa-reminder');

Route::post('/data_allexport', 'ApplicantController@data_allexport');
Route::post('/data_incompleteapplicant', 'ApplicantController@data_incompleteapplicant');
Route::post('/data_allapplicant', 'ApplicantController@data_allapplicant');
Route::post('/data_rejectedapplicant', 'ApplicantController@data_rejectedapplicant');
Route::post('/data_passapplicant', 'ApplicantController@data_passapplicant');
Route::post('/data_offerapplicant', 'ApplicantController@data_offerapplicant');
Route::post('/data_publishedapplicant', 'ApplicantController@data_publishedapplicant');
Route::post('/data_statusapplicant', 'ApplicantController@data_statusapplicant');
Route::post('/data_acceptedapplicant', 'ApplicantController@data_acceptedapplicant');
Route::get('/export_applicant', 'ApplicantController@applicant_all');
Route::get('/export', 'ApplicantController@export');
Route::post('/export', 'ApplicantController@export');
Route::get('exportapplicant/{intake?}/{programme?}/{batch?}/{status?}','ApplicantController@export');
// Route::post('/import_excel/import', 'ApplicantController@import')
Route::post('import-excel','ApplicantController@import');
Route::get('attachmentFile/{filename}/{type}','ApplicantController@sponsorAttachment');
Route::get('send-bulk-mail', 'ApplicantController@sendBulkMail')->name('send-bulk-mail');

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

//PHYSICAL REGISTRATION
Route::resource('/physical-registration', 'PhysicalRegistrationController');
Route::post('/data_newstudent', 'PhysicalRegistrationController@data_newstudent');
Route::post('/new-student', 'PhysicalRegistrationController@newstudent')->name('new-student');

//APPLICANT REGISTRATION
Route::resource('/registration','RegistrationController');
Route::patch('update/{id}/{type}','RegistrationController@update');

// Route::get('/check/{id}','RegistrationController@getUsers');
Route::get('/applicantRegister', 'RegistrationController@register')->name('applicantRegister.index');
Route::get('search', 'RegistrationController@search');
Route::get('applicantRegister/check/{id}/{intake_id}', 'RegistrationController@check');
Route::get('registration/printRef/{id}','RegistrationController@printRef')->name('printRef');
Route::get('registration/printReg/{id}','RegistrationController@printReg')->name('printReg');
Route::get('registration-data/{id}','RegistrationController@data');
Route::get('registration-mode/{id}','RegistrationController@study_mode');
Route::get('testmajor','RegistrationController@testmajor');
Route::post('applicant/delete/{id}/{type}/{userid}','RegistrationController@deleteitem');
Route::get('qualificationfile/{filename}/{type}','RegistrationController@qualificationfile');
Route::get('attachmentFile/{filename}/{type}','RegistrationController@attachmentFile');

//SPONSOR
Route::resource('param/sponsor','SponsorController');
Route::post('/data_sponsor', 'SponsorController@data_sponsor');

//INTAKE
Route::resource('/intake','IntakeController');
Route::post('/data-allintake', 'IntakeController@data_allintake');
Route::post('createprograminfo','IntakeController@createProgramInfo');
Route::delete('deleteProgramInfo/{id}', 'IntakeController@deleteProgramInfo')->name('deleteProgramInfo');
Route::get('/intake-info','IntakeController@intakeInfo');
Route::post('updateProgramInfo', 'IntakeController@updateProgramInfo');
Route::get('/letter', 'IntakeController@letter')->name('letter');
Route::get('/emails', 'IntakeController@sendEmail')->name('emails');
Route::get('programme-batch/{id}','IntakeController@data');
Route::get('getIntakeFiles/{batchCode}','IntakeController@getIntakeFiles');
Route::get('storageFile/{filename}/{type}','IntakeController@storageFile');
Route::get('deleteStorage/{id}','IntakeController@deleteStorage');

//BATCH
Route::resource('/batch', 'BatchController')->middleware('can:check requirement');
Route::post('/data-allbatch', 'BatchController@data_allbatch')->middleware('can:check requirement');

//LEAD
Route::get('/lead/active_lead', 'LeadController@activeLead');
Route::post('api/lead/list', 'LeadController@data_lead_list');  //datatable
Route::get('/lead/new_lead', 'LeadController@newLead');
Route::get('/lead/follow_lead/{id}', 'LeadController@followLead')->name('followLead');
Route::post('updateFollow', 'LeadController@updateFollow');
Route::post('newLeadStore', 'LeadController@newLeadStore')->name('newLead');
Route::delete('lead/active_lead/{id}', 'LeadController@deleteLeadInfo');
Route::post('api/followTrack/list', 'LeadController@data_followTrack_list');  //datatable
Route::get('/lead/edit_followLead/{id}', 'LeadController@editFollowLead')->name('editFollow');
Route::post('updateEditFollow', 'LeadController@updateEditFollow');
Route::delete('deleteFollowInfo/{id}', 'LeadController@deleteFollowInfo')->name('deleteFollowInfo');
Route::post('createfollowinfo','LeadController@createFollowInfo');
Route::get('/lead/inactive_lead', 'LeadController@inactiveLead');
Route::get('/lead/inactive_lead_un', 'LeadController@inactiveUnLead');
Route::post('api/inactiveLead/list', 'LeadController@data_inactiveLead_list');  //datatable
Route::post('api/inactiveUnLead/list', 'LeadController@data_inactiveUnLead_list');  //datatable
Route::post('updateAssign', 'LeadController@updateAssign');
Route::get('/lead/group_list', 'LeadController@groupList');
Route::get('/lead/group_new', 'LeadController@groupNew');
Route::post('groupNewStore', 'LeadController@groupNewStore')->name('newGroup');
Route::get('/lead/group_edit/{id}', 'LeadController@editGroup')->name('editGroup');
Route::post('updateGroup', 'LeadController@updateGroup');
Route::delete('lead/group_list/{id}', 'LeadController@deleteGroupInfo');
Route::post('api/group/list', 'LeadController@data_group_list');  //datatable
Route::get('/letter', 'LeadController@letter')->name('letter'); 
Route::get('/emails', 'LeadController@sendEmail')->name('email'); 
Route::get('/export_lead', 'LeadController@lead_all');
Route::post('/data_leadexport', 'LeadController@data_leadexport');
Route::get('/export', 'LeadController@exports');
Route::post('/export', 'LeadController@exports');
Route::get('exportlead/{group?}/{status?}','LeadController@exports');
Route::get('/lead/email_blast', 'LeadController@emailBlast');
Route::post('/email_blast', 'LeadController@sendEmailBlast')->name('email');

//REGISTER USER
Route::resource('/user','UserController');
Route::post('/data_alluser', 'UserController@data_alluser');

//PARAM
Route::resource('/intakeType', 'IntakeTypeController');
Route::resource('param/programme', 'ProgrammeController')->middleware('can:view parameter');
Route::resource('param/course', 'CourseController')->middleware('can:view parameter');
Route::resource('param/major', 'MajorController')->middleware('can:view parameter');
Route::resource('param/source', 'SourceController')->middleware('can:view parameter');
Route::post('data-intakeType', 'IntakeTypeController@data_intakeType');
Route::post('data-allProgramme', 'ProgrammeController@data_allProgramme');
Route::post('data-allMajor', 'MajorController@data_allMajor');
Route::post('data-allCourse', 'CourseController@data_allCourse');
Route::post('createSources','SourceController@createSources');
Route::post('updateSources','SourceController@updateSources');
Route::post('data-allSource', 'SourceController@data_allSource');
Route::post('preInfo','CourseController@preInfo');
Route::post('coInfo','CourseController@coInfo');

//OFFER LETTER
// Route::get('/offer-letter', 'EntryRequirementController@offer');

//STUDENTS:
//biodata
Route::get('/student/biodata/basic_info/{id}', 'StudentController@basic_info');
Route::get('/student/biodata/addressContact_info/{id}', 'StudentController@addressContact_info');
Route::get('/student/biodata/addressContact_edit/{id}', 'StudentController@addressContact_edit');
Route::post('updateStudent', 'StudentController@updateStudent');
//registration
Route::get('/student/registration/course_register', 'StudentController@course_register');
Route::get('/student/registration/courseSlip_pdf', 'StudentController@course_pdf');
Route::get('/student/registration/credit_exemption', 'StudentController@credit_exemption');
Route::get('/student/registration/project_info', 'StudentController@project_info');
// Route::post('data-allCourse_exemp', 'StudentController@data-allCourse_exemp');
// Route::post('data-allProject', 'StudentController@data-allProject');
// //examination
Route::get('/student/examination/course_performance', 'StudentController@course_performance')->name('course_performance');
Route::get('/student/examination/exam_details', 'StudentController@exam_details');
//graduation
Route::get('/student/graduation/graduation_info', 'StudentController@graduation_info');
//financial
Route::get('/student/financial/stud_statement', 'StudentController@stud_statement');
//others
Route::get('/student/others/activity_trans', 'StudentController@activity_transcript');
Route::get('/student/others/residential_rcrd', 'StudentController@residential_record');
Route::get('/student/others/vehicle_rcrd', 'StudentController@vehicle_record');
// Route::get('/student/others/resident_electric', 'StudentController@residential_electric');
//services
Route::get('student/services/sw_download', 'StudentController@sw_download');

//AJAX DATA STUDENTS
Route::post('data_allstudents', 'StudentController@data_allstudents');
Route::post('data_studentWithNonNumericId', 'StudentController@data_studentWithNonNumericId');
Route::post('data_studentWithNullName', 'StudentController@data_studentWithNullName');

//AJAX DATA COURSES
Route::post('data_allcourses', 'CourseController@data_allcourses');


Route::get('student/filter/{id}','StudentController@indexFiltered');

//API data source
Route::post('api/semester/list', 'SemesterController@data_semester_list');
Route::post('api/campus/list', 'CampusController@data_campus_list');  //campus
Route::post('api/zone/list', 'ZoneController@data_zone_list');  //zone
Route::post('api/building/list', 'BuildingController@data_building_list');  //building
Route::post('api/level/list', 'LevelController@data_level_list');  //level
Route::post('api/roomtype/list', 'RoomTypeController@data_roomtype_list');  //roomtype
Route::post('api/roomsuitability/list', 'RoomSuitabilityController@data_roomsuitability_list');  //roomsuitability
Route::post('api/roomfacility/list', 'RoomFacilityController@data_roomfacility_list');  //roomfacility
Route::post('api/roomowner/list', 'RoomOwnerController@data_roomowner_list');  //roomowner

//Super Admin features
Route::get('admin/adduser','UserController@create');
Route::post('admin/storenewuser','UserController@store');

//Queue
Route::get('/startQueue',function(){
    exec('php artisan queue:work --tries=2 &');
    return 1;
})->name('startQueue');

