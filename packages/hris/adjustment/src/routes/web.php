<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Adjustment\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('adjustments', 'AdjustmentController');
    Route::patch('adjustments/{id}/status', 'AdjustmentController@changeStatus')->name('adjustments.status');
    Route::resource('adjustmentreasons', 'AdjustmentreasonController');
    
});

Route::group([
    'namespace' => 'Hris\Adjustment\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('adjustments', 'AdjustmentController');
    Route::patch('adjustments/{id}/status', 'AdjustmentController@changeStatus')->name('adjustments.status');
    Route::resource('adjustmentreasons', 'AdjustmentreasonController');
});

Route::group([
    'namespace' => 'Hris\Adjustment\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('adjustments', 'AdjustmentController');
    Route::patch('adjustments/{id}/status', 'AdjustmentController@changeStatus')->name('adjustments.status');
    Route::resource('adjustmentreasons', 'AdjustmentreasonController');
});