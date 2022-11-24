<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Attendance\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('attendances', 'AttendanceController');
    Route::post('attendance_approval', 'AttendanceController@approveAll')->name('attendances.approveAll');
    Route::patch('attendances/{id}/approve','AttendanceController@approve')->name('attendances.approve');
    Route::patch('attendances/{id}/reject','AttendanceController@reject')->name('attendances.reject');

    Route::get('attendance_handler', 'AttendanceHandlerController@index')->name('attendanceHandler.index');
    Route::post('attendance_handler', 'AttendanceHandlerController@approve')->name('attendanceHandler.approve');
    Route::post('attendance_handler/generate', 'AttendanceHandlerController@generate')->name('attendanceHandler.generate');
    Route::post('attendance_handler/export', 'AttendanceHandlerController@export')->name('attendanceHandler.export');
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

    Route::get('attendance_handler', 'AttendanceHandlerController@index')->name('attendanceHandler.index');
    Route::post('attendance_handler', 'AttendanceHandlerController@approve')->name('attendanceHandler.approve');
    Route::post('attendance_handler/generate', 'AttendanceHandlerController@generate')->name('attendanceHandler.generate');
    Route::post('attendance_handler/export', 'AttendanceHandlerController@export')->name('attendanceHandler.export');
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

    Route::get('attendance_handler', 'AttendanceHandlerController@index')->name('attendanceHandler.index');
    Route::post('attendance_handler', 'AttendanceHandlerController@approve')->name('attendanceHandler.approve');
    Route::post('attendance_handler/generate', 'AttendanceHandlerController@generate')->name('attendanceHandler.generate');
    Route::post('attendance_handler/export', 'AttendanceHandlerController@export')->name('attendanceHandler.export');
});