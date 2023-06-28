<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Outsource\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('outsources', 'OutsourceController');
    Route::get('outsources_export', 'OutsourceController@export')->name('outsources.export');

    Route::group([
        'prefix' => 'outsources/{id}',
        'as' => 'outsources.'
    ], function(){
        Route::resource('/documents', 'OutsourceDocumentController')->only(['index', 'store', 'destroy']);
        Route::resource('/purchase', 'OutsourcePurchaseController')->only(['index', 'store', 'destroy']);
        Route::resource('/staffs', 'OutsourceStaffController');
        Route::post('/staff_checklist/{staff_id}', 'OutsourceStaffController@saveChecklist')->name('staffs.checklist');

        Route::get('/staff_export', 'OutsourceStaffController@export_staff')->name('staffs.export_staff');
        Route::post('/import','OutsourceStaffController@import_staff')->name('staffs.import_staff');
    });

});

Route::group([
    'namespace' => 'Hris\Outsource\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('outsources', 'OutsourceController');
    Route::get('outsources_export', 'OutsourceController@export')->name('outsources.export');

    Route::group([
        'prefix' => 'outsources/{id}',
        'as' => 'outsources.'
    ], function(){
        Route::resource('/documents', 'OutsourceDocumentController')->only(['index', 'store', 'destroy']);
        Route::resource('/purchase', 'OutsourcePurchaseController')->only(['index', 'store', 'destroy']);
        Route::resource('/staffs', 'OutsourceStaffController');
        Route::post('/staff_checklist/{staff_id}', 'OutsourceStaffController@saveChecklist')->name('staffs.checklist');

        Route::get('/staff_export', 'OutsourceStaffController@export_staff')->name('staffs.export_staff');
        Route::post('/import','OutsourceStaffController@import_staff')->name('staffs.import_staff');
    });

});

Route::group([
    'namespace' => 'Hris\Outsource\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('outsources', 'OutsourceController');
    Route::get('outsources_export', 'OutsourceController@export')->name('outsources.export');

    Route::group([
        'prefix' => 'outsources/{id}',
        'as' => 'outsources.'
    ], function(){
        Route::resource('/documents', 'OutsourceDocumentController')->only(['index', 'store', 'destroy']);
        Route::resource('/purchase', 'OutsourcePurchaseController')->only(['index', 'store', 'destroy']);
        Route::resource('/staffs', 'OutsourceStaffController');
        Route::post('/staff_checklist/{staff_id}', 'OutsourceStaffController@saveChecklist')->name('staffs.checklist');

        Route::get('/staff_export', 'OutsourceStaffController@export_staff')->name('staffs.export_staff');
        Route::post('/import','OutsourceStaffController@import_staff')->name('staffs.import_staff');
    });
    
});