<?php

use Illuminate\Support\Facades\Route;

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

/* START:Backend */
Route::group(['prefix' => 'superadmin', 'namespace' => 'Superadmin', 'as'=>'superadmin.'], function () {

    /* Auth */
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth:superadmin']], function () {

        /* Account */
        Route::group(['prefix' => 'account', 'as'=>'account.', 'middleware' => 'role:admin|moderator'], function () {

            Route::get('/profile', 'ProfileController@viewProfile')->name('profile.view');
            Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');
            Route::post('/profile/remove-image/{id}', 'ProfileController@removeImage')->name('profile.remove-image');
            Route::get('change-password', 'ProfileController@viewChangePassword')->name('change-password.view');
            Route::post('change-password', 'ProfileController@saveChangePassword')->name('change-password.update');

        });
        
        Route::get('/', 'DashboardController@index')->name('dashboard')->middleware('role:admin|moderator');
        
        Route::resource('user', 'UserController')->middleware('role:admin');

        Route::resource('powerplant', 'PowerPlantController')->middleware('role:admin');

        Route::group(['prefix' => 'powerplant', 'as'=>'powerplant.'],function(){
        
        Route::post('change-status/{id}','PowerPlantController@changeStatus')->name('change-status')->middleware('role:admin');

        });

        Route::get('schedule-report', 'PowerScheduleController@getCSV')->name('schedule-report');
        Route::get('schedule-graph', 'PowerScheduleController@showGraph')->name('schedule-graph');

        Route::get('get-schedule-data', 'PowerScheduleController@getGraphData')->name('get-schedule-data');

        Route::resource('schedule', 'PowerScheduleController')->middleware('role:admin');
        

    });
});


Route::group(['prefix' => 'account', 'as'=>'account.','middleware'=>'auth'],function(){

    Route::get('/profile', 'UserProfile\ProfileController@viewProfile')->name('profile.view');
    Route::post('/profile/update', 'UserProfile\ProfileController@updateProfile')->name('profile.update');
    Route::get('change-password', 'UserProfile\ProfileController@viewChangePassword')->name('change-password.view');

    Route::post('/profile/remove-image/{id}', 'UserProfile\ProfileController@removeImage')->name('profile.remove-image');

    Route::post('change-password', 'UserProfile\ProfileController@saveChangePassword')->name('change-password.update');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/* START:Frontend */
Route::group(['middleware'=>'auth'], function () {

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::get('schedule-with-ajax', 'PowerScheduleController@withAjaxSchedule')->name('schedule-with-ajax');

Route::get('schedule-ajax-listing', 'PowerScheduleController@ajaxListing')->name('schedule-ajax-listing');

Route::resource('schedule', 'PowerScheduleController');

Route::get('schedule-report', 'PowerScheduleController@getCSV')->name('schedule-report');


});