<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Attendance\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('attendancesss', 'AttendanceController');
    Route::post('attendance_approval', 'AttendanceController@approveAll')->name('attendances.approveAll');
    Route::patch('attendances/{id}/approve','AttendanceController@approve')->name('attendances.approve');
    Route::patch('attendances/{id}/reject','AttendanceController@reject')->name('attendances.reject');
});

Route::group([
    'namespace' => 'Hris\Attendance\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('attendances', 'AttendanceController');
    Route::post('attendance_approval', 'AttendanceController@approveAll')->name('attendances.approveAll');
    Route::patch('attendances/{id}/approve','AttendanceController@approve')->name('attendances.approve');
    Route::patch('attendances/{id}/reject','AttendanceController@reject')->name('attendances.reject');
});

Route::group([
    'namespace' => 'Hris\Attendance\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('attendances', 'AttendanceController');
    Route::post('attendance_approval', 'AttendanceController@approveAll')->name('attendances.approveAll');
    Route::patch('attendances/{id}/approve','AttendanceController@approve')->name('attendances.approve');
    Route::patch('attendances/{id}/reject','AttendanceController@reject')->name('attendances.reject');
});