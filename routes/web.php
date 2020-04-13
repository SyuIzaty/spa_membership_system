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

   return view('welcome');
});




//Auth::routes();

Route::resource('student', 'StudentController');
Route::resource('course', 'CourseController');

//AJAX DATA STUDENTS
Route::post('data_allstudents', 'StudentController@data_allstudents');
Route::post('data_studentWithNonNumericId', 'StudentController@data_studentWithNonNumericId');
Route::post('data_studentWithNullName', 'StudentController@data_studentWithNullName');

//AJAX DATA COURSES
Route::post('data_allcourses', 'CourseController@data_allcourses');


Route::get('student/filter/{id}','StudentController@indexFiltered');
