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

   return redirect('student');
});




// Auth::routes();
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

Route::get('/applicant','ApplicantController@create');

Route::post('applicant/{applicant}/showapp','ApplicantController@showapp')->name('applicant.showapp');
Route::get('applicant/{applicant}/profile','ApplicantController@profile')->name('applicant.profile');
Route::get('applicant/{applicant}/contact','ApplicantController@createcontact')->name('applicant.createcontact');
Route::get('applicant/{applicant}/contactinfo','ApplicantController@contactinfo')->name('applicant.contactinfo');
Route::get('applicant/{applicant}/prefprogramme','ApplicantController@prefprogramme')->name('applicant.prefprogramme');
Route::get('applicant/{applicant}/address','ApplicantController@address')->name('applicant.address');
Route::post('applicant/{applicant}/storecontact','ApplicantController@storecontact')->name('applicant.storecontact');
Route::get('applicant/{applicant}/updateprogramme','ApplicantController@updateprogramme')->name('applicant.updateprogramme');
Route::get('applicant/{applicant}/updatecontact','ApplicantController@updatecontact')->name('applicant.updatecontact');
Route::get('applicant/{applicant}/academic','ApplicantController@createacademic')->name('applicant.createacademic');
Route::get('applicant/{applicant}/storeacademic','ApplicantController@storeacademic')->name('applicant.storeacademic');
Route::get('applicant/{applicant}/academicinfo','ApplicantController@academicinfo')->name('applicant.academicinfo');
Route::get('applicant/{applicant}/updateacademic','ApplicantController@updateacademic')->name('applicant.updateacademic');



Route::get('/applicantresult','ApplicantController@indexs');
Route::get('checkrequirements', 'ApplicantController@checkrequirements')->name('check-requirements');
Route::post('changestatus', 'ApplicantController@changestatus');
Route::post('programmestatus', 'ApplicantController@programmestatus');

Route::post('/data_allapplicant', 'ApplicantController@data_allapplicant');
Route::post('/data_rejectedapplicant', 'ApplicantController@data_rejectedapplicant');
Route::post('/data_passapplicant', 'ApplicantController@data_passapplicant');
Route::post('/data_offerapplicant', 'ApplicantController@data_offerapplicant');

Route::get('testCollection','ApplicantController@testCollection');

//INTAKE
Route::resource('/intake','IntakeController');
Route::post('/data-allintake', 'IntakeController@data_allintake');
Route::post('createprograminfo','IntakeController@createProgramInfo');
Route::delete('deleteProgramInfo/{id}', 'IntakeController@deleteProgramInfo')->name('deleteProgramInfo');
Route::get('/intake-info','IntakeController@intakeInfo');
Route::get('/letter', 'IntakeController@letter')->name('letter');

//OFFER LETTER
Route::get('/offer-letter', 'EntryRequirementController@offer');

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
