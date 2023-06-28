<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Holiday\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('holidays', 'HolidayController');
});

Route::group([
    'namespace' => 'Hris\Holiday\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('holidays', 'HolidayController');
});

Route::group([
    'namespace' => 'Hris\Holiday\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('holidays', 'HolidayController');
    
});