<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api',
], function () {
	// Category
    Route::get('/categories', 'API\CategoryController@all');
    Route::post('/category', 'API\CategoryController@store');
    Route::delete('/category/{id}', 'API\CategoryController@destroy');
    Route::put('/category/{id}', 'API\CategoryController@update');

    // People
    Route::get('/contacts', 'API\AppointmentController@allContacts');
    Route::post('/new/contact', 'API\AppointmentController@createContact');
    Route::post('/new/organisation', 'API\AppointmentController@createOrganisation');
  

    // Org Contact
    Route::get('/organisations', 'API\AppointmentController@allOrganisations');
    Route::get('/organisation/{id}', 'API\AppointmentController@address');

    // Appointment
    Route::get('/appointments/{start}/{end}', 'API\AppointmentController@all');
    Route::get('/tasks/{start}/{end}', 'API\AppointmentController@allTask');
    Route::post('/appointment', 'API\AppointmentController@store');
    Route::delete('/appointment/{id}', 'API\AppointmentController@destroy');
    Route::put('/appointment/{id}', 'API\AppointmentController@update');
    Route::post('/appointment/update', 'API\AppointmentController@eventUpdate');
    Route::post('/task/update', 'API\AppointmentController@eventTaskUpdate');

    // Add PWD Member
    Route::get('/members', 'API\MemberController@all');
    Route::post('/add-member', 'API\MemberController@store');
    Route::delete('/delete-member/{id}', 'API\MemberController@destroy');
    Route::post('/sms/test', 'API\MemberController@smsTest');

    // Create Note
    Route::get('/notes/{id}', 'API\DairyController@getNotes');
    Route::post('/note/{id}', 'API\DairyController@postNote');
    Route::delete('/note/{id}', 'API\DairyController@deleteNote');
    Route::put('/note/{id}', 'API\DairyController@updateNote');

    Route::get('/photos/{id}', 'API\DairyController@getPhotos');
    Route::post('/photo/{id}', 'API\DairyController@postPhoto');
    // Check In
    Route::post('/checkin/{id}', 'MobileController@checkin');
    Route::post('/taskcheckin/{id}', 'MobileController@taskCheckin');
    //Profile
    Route::put('/settings/profile/details', 'API\ProfileDetailsController@update');
    Route::post('/update/about-me', 'API\ProfileDetailsController@updateAboutMe');

    //Contact Photo
    Route::post('/contact/photo', 'API\ContactController@uploadPhoto');

});
