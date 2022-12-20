<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Overtime\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('overtimes', 'OvertimeController');
    Route::patch('overtimes/{id}/status', 'OvertimeController@changeStatus')->name('overtimes.status');
    Route::resource('overtimereasons', 'OvertimereasonController');
    
});

Route::group([
    'namespace' => 'Hris\Overtime\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('overtimes', 'OvertimeController');
    Route::patch('overtimes/{id}/status', 'OvertimeController@changeStatus')->name('overtimes.status');
    Route::resource('overtimereasons', 'OvertimereasonController');
});

Route::group([
    'namespace' => 'Hris\Overtime\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('Overtimes', 'OvertimeController');
    Route::patch('Overtimes/{id}/status', 'OvertimeController@changeStatus')->name('Overtimes.status');
    Route::resource('overtimereasons', 'OvertimereasonController');
});