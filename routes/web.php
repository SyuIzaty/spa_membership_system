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
    return redirect('/home');
});

Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login')->name('login');
Route::post('/logout', 'LoginController@logout')->name('logout');
Route::get('/signup', 'LoginController@signup');
Route::post('/register-signup', 'LoginController@registerSignup')->name('registerSignup');
Route::get('/password', 'LoginController@password');
Route::post('/reset-password', 'LoginController@resetPassword')->name('resetPassword');

Route::group(['middleware' => ['no-cache']], function () {

    Route::get('/home', 'CustomerHomeController@index');
    Route::get('/about', 'CustomerAboutController@index');
    Route::get('/service', 'CustomerServiceController@index');
    Route::get('/membership', 'CustomerMembershipController@index');
    Route::post('register-membership', 'CustomerMembershipController@registerMembership');
    Route::get('/booking', 'CustomerBookingController@index');
    Route::post('register-booking', 'CustomerBookingController@registerBooking');
    Route::get('/profile', 'CustomerProfileController@index');
    Route::post('update-profile', 'CustomerProfileController@updateProfile');
    Route::get('/contact', 'CustomerContactController@index');
    Route::get('/policy', 'CustomerPolicyController@index');

});

Route::group(['middleware' => ['auth', 'no-cache']], function () {

    Route::get('/list-service', 'ServiceController@index');
    Route::post('data-service', 'ServiceController@dataService');
    Route::post('store-service', 'ServiceController@storeService');
    Route::post('update-service', 'ServiceController@updateService');
    Route::get('/get-service/{id}', 'ServiceController@getService');
    Route::delete('/delete-service/{id}', 'ServiceController@deleteService')->name('deleteService');

    Route::get('/list-discount', 'DiscountController@index');
    Route::post('data-discount', 'DiscountController@dataDiscount');
    Route::post('store-discount', 'DiscountController@storeDiscount');
    Route::post('update-discount', 'DiscountController@updateDiscount');
    Route::get('/get-discount/{id}', 'DiscountController@getDiscount');
    Route::delete('/delete-discount/{id}', 'DiscountController@deleteDiscount')->name('deleteDiscount');

    Route::get('/list-membership', 'MembershipPlanController@index');
    Route::post('data-membership', 'MembershipPlanController@dataMembership');
    Route::post('store-membership', 'MembershipPlanController@storeMembership');
    Route::post('update-membership', 'MembershipPlanController@updateMembership');
    Route::get('/get-membership/{id}', 'MembershipPlanController@getMembership');
    Route::delete('/delete-membership/{id}', 'MembershipPlanController@deleteMembership')->name('deleteMembership');

    Route::get('/list-staff', 'StaffController@index');
    Route::post('data-staff', 'StaffController@dataStaff');
    Route::post('store-staff', 'StaffController@storeStaff');
    Route::post('update-staff', 'StaffController@updateStaff');
    Route::get('/get-staff/{id}', 'StaffController@getStaff');
    Route::delete('/delete-staff/{id}', 'StaffController@deleteStaff')->name('deleteStaff');

    Route::get('/list-member', 'MemberController@index');
    Route::post('data-member', 'MemberController@dataMember');
    Route::post('data-non-member', 'MemberController@dataNonMember');
    Route::get('/show-member-detail/{id}', 'MemberController@showMemberDetail');
    Route::post('/data-member-booking/{id}', 'MemberController@dataMemberBooking');

    Route::resource('/list-booking', 'BookingController');
});
