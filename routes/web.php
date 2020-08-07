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

//APPLICANTS

Route::get('/applicant','ApplicantController@create');

Route::post('applicant/{applicant}','ApplicantController@showapp')->name('applicant.showapp');
Route::get('applicant/{applicant}','ApplicantController@profile')->name('applicant.profile');
Route::get('applicant/{applicant}/prefprogramme','ApplicantController@prefprogramme')->name('applicant.prefprogramme');
Route::get('applicant/{applicant}/address','ApplicantController@address')->name('applicant.address');
Route::get('applicant/{applicant}/contact','ApplicantController@contact')->name('applicant.contact');
Route::get('applicant/{applicant}/updateprogramme','ApplicantController@updateprogramme')->name('applicant.updateprogramme');;




Route::get('/applicantresult','ApplicantController@indexs');
Route::get('checkrequirements', 'ApplicantController@checkrequirements')->name('check-requirements');
Route::post('changestatus', 'ApplicantController@changestatus');
Route::post('programmestatus', 'ApplicantController@programmestatus');

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
Route::post('api/campus/list', 'CampusController@data_campus_list');
