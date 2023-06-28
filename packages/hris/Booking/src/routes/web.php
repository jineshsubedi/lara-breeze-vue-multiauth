<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Booking\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('bookingpurposes', 'BookingPurposeController');
    Route::resource('bookingplaces', 'BookingPlaceController');
    Route::resource('bookinghalls', 'BookingHallController');

    Route::resource('bookings', 'BookingController');
    Route::get('bookings/{id}/participants', 'BookingController@getParticipants')->name('bookings.getParticipants');
    Route::post('bookings/{id}/participants', 'BookingController@saveParticipants')->name('bookings.saveParticipants');
    Route::delete('booking_participant/{id}', 'BookingController@removeParticipants')->name('bookings.removeParticipants');
    Route::post('booking_participant/{id}/status', 'BookingController@updateStatus')->name('bookings.updateStatus');
});

Route::group([
    'namespace' => 'Hris\Booking\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('bookingpurposes', 'BookingPurposeController');
    Route::resource('bookingplaces', 'BookingPlaceController');
    Route::resource('bookinghalls', 'BookingHallController');

    Route::resource('bookings', 'BookingController');
    Route::get('bookings/{id}/participants', 'BookingController@getParticipants')->name('bookings.getParticipants');
    Route::post('bookings/{id}/participants', 'BookingController@saveParticipants')->name('bookings.saveParticipants');
    Route::delete('booking_participant/{id}', 'BookingController@removeParticipants')->name('bookings.removeParticipants');
    Route::post('booking_participant/{id}/status', 'BookingController@updateStatus')->name('bookings.updateStatus');
});

Route::group([
    'namespace' => 'Hris\Booking\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('bookingpurposes', 'BookingPurposeController');
    Route::resource('bookingplaces', 'BookingPlaceController');
    Route::resource('bookinghalls', 'BookingHallController');

    Route::resource('bookings', 'BookingController');
    Route::get('bookings/{id}/participants', 'BookingController@getParticipants')->name('bookings.getParticipants');
    Route::post('bookings/{id}/participants', 'BookingController@saveParticipants')->name('bookings.saveParticipants');
    Route::delete('booking_participant/{id}', 'BookingController@removeParticipants')->name('bookings.removeParticipants');
    Route::post('booking_participant/{id}/status', 'BookingController@updateStatus')->name('bookings.updateStatus');
});