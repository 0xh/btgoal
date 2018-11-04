<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'WelcomeController@show');
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/home', 'HomeController@show');
Route::get('/welcome', 'HomeController@welcome');
// Route::post('/login', 'Auth\BgLoginController@login');
Route::get('/category', 'HomeController@category');
Route::resource('contacts', 'ContactController');
Route::resource('organisations', 'OrganisationController');
Route::get('/task-report', 'HomeController@task');
Route::get('/appointment-report', 'HomeController@appointment');
Route::get('/about-me', 'HomeController@aboutme');

// Route::get('/organisation', 'HomeController@organisation');
Route::get('/appointment/list', 'AptController@showAllAppointment');
Route::get('/appointment/list/sort', 'AptController@sortAllAppointment');
Route::post('/appointments/delete', 'AptController@bulkDeleteAppointment');
Route::get('/appointment', 'AptController@addAppointment');
Route::post('/appointment/create', 'AptController@store');
Route::post('/appointment/update/{id}', 'AptController@updateAppointment');
Route::get('/appointment/{id}', 'AptController@viewAppointment');
Route::delete('/appointment/delete', 'AptController@deleteAppointment');
Route::get('/task/{id}', 'AptController@viewTask');
Route::post('/task/update/{id}', 'AptController@updateTask');
Route::delete('/task/delete', 'AptController@deleteTask');

// Mobile Routes
Route::get('/mobile-home', 'MobileController@home');
Route::get('/mobile-calendar', 'MobileController@calendar');
Route::get('/mobile-settings', 'MobileController@settings');
Route::get('/mobile-appointment/{id}', 'MobileController@appointment');
Route::get('/tsk/{id}', 'MobileController@task');
Route::get('/apt/{id}', 'MobileController@appointment');
Route::get('/new/mobile-appointment', 'MobileController@add');
Route::get('/edit/mobile-appointment/{id}', 'MobileController@edit');
Route::get('/mobile/people', 'MobileController@people');
Route::get('/mobile/people/{id}', 'MobileController@editPeople');
Route::get('/mobile/add/people', 'MobileController@addPeople');
Route::get('/mobile/places', 'MobileController@places');
Route::get('/mobile/place/{id}', 'MobileController@editPlace');
Route::get('/mobile/add/place', 'MobileController@addPlace');
Route::get('/mobile/about-me', 'MobileController@aboutMe');

