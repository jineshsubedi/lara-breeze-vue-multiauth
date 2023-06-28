<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Offboarding\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resources([
        'offboardsettings' => 'OffboardSettingController',
        'offboardprocesses' => 'OffboardProcessController',
        'resignationreasons' => 'ResignationReasonController',
        'resignationtypes' => 'ResignationTypeController',
        'disciplinarygrounds' => 'DisciplinaryGroundController',
        'terminationtypes' => 'TerminationTypeController',
        'disciplinaryactions' => 'DisciplinaryActionController',
        'abscondings' => 'AbscondingController',
        'resignationstaffs' => 'ResignationStaffController',
        'resignations' => 'ResignationController',
        'terminatestaffs' => 'TerminateStaffController',
    ]);
    Route::post('disciplinaryactions/{id}/teriminate_staff', 'DisciplinaryActionController@terminatestaff')->name('disciplinaryactions.terminatestaff');
    Route::get('disciplinaryactions/{id}/hold_staff', 'DisciplinaryActionController@holdstaff')->name('disciplinaryactions.holdstaff');

    Route::resource('disciplinary', 'DisciplinaryController')->only(['index', 'show', 'update']);
    
    Route::post('abscondings/{id}/teriminate_staff', 'AbscondingController@terminatestaff')->name('abscondings.terminatestaff');
    Route::get('abscondings/{id}/hold_staff', 'AbscondingController@holdstaff')->name('abscondings.holdstaff');

    // Route::get('offboarding', 'OffboardingController@index')->name('offbording.index');
    Route::post('resignation/approval', 'ResignationController@approval')->name('resignations.approval');

    Route::post('/resignation/retraction','ResignationController@retraction')->name('retraction.save');
    Route::post('/resignation/retraction_approval','ResignationStaffController@retraction_approval')->name('retraction.approval');

});

Route::group([
    'namespace' => 'Hris\Offboarding\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resources([
        'offboardsettings' => 'OffboardSettingController',
        'offboardprocesses' => 'OffboardProcessController',
        'resignationreasons' => 'ResignationReasonController',
        'resignationtypes' => 'ResignationTypeController',
        'disciplinarygrounds' => 'DisciplinaryGroundController',
        'terminationtypes' => 'TerminationTypeController',
        'disciplinaryactions' => 'DisciplinaryActionController',
        'abscondings' => 'AbscondingController',
        'resignationstaffs' => 'ResignationStaffController',
        'resignations' => 'ResignationController',
        'terminatestaffs' => 'TerminateStaffController',
    ]);
    Route::post('disciplinaryactions/{id}/teriminate_staff', 'DisciplinaryActionController@terminatestaff')->name('disciplinaryactions.terminatestaff');
    Route::get('disciplinaryactions/{id}/hold_staff', 'DisciplinaryActionController@holdstaff')->name('disciplinaryactions.holdstaff');

    Route::resource('disciplinary', 'DisciplinaryController')->only(['index', 'show', 'update']);
    
    Route::post('abscondings/{id}/teriminate_staff', 'AbscondingController@terminatestaff')->name('abscondings.terminatestaff');
    Route::get('abscondings/{id}/hold_staff', 'AbscondingController@holdstaff')->name('abscondings.holdstaff');

    // Route::get('offboarding', 'OffboardingController@index')->name('offbording.index');
    Route::post('resignation/approval', 'ResignationController@approval')->name('resignations.approval');

    Route::post('/resignation/retraction','ResignationController@retraction')->name('retraction.save');
    Route::post('/resignation/retraction_approval','ResignationStaffController@retraction_approval')->name('retraction.approval');

});

Route::group([
    'namespace' => 'Hris\Offboarding\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resources([
        'offboardsettings' => 'OffboardSettingController',
        'offboardprocesses' => 'OffboardProcessController',
        'resignationreasons' => 'ResignationReasonController',
        'resignationtypes' => 'ResignationTypeController',
        'disciplinarygrounds' => 'DisciplinaryGroundController',
        'terminationtypes' => 'TerminationTypeController',
        'disciplinaryactions' => 'DisciplinaryActionController',
        'abscondings' => 'AbscondingController',
        'resignationstaffs' => 'ResignationStaffController',
        'resignations' => 'ResignationController',
        'terminatestaffs' => 'TerminateStaffController',
    ]);
    Route::post('disciplinaryactions/{id}/teriminate_staff', 'DisciplinaryActionController@terminatestaff')->name('disciplinaryactions.terminatestaff');
    Route::get('disciplinaryactions/{id}/hold_staff', 'DisciplinaryActionController@holdstaff')->name('disciplinaryactions.holdstaff');

    Route::resource('disciplinary', 'DisciplinaryController')->only(['index', 'show', 'update']);
    
    Route::post('abscondings/{id}/teriminate_staff', 'AbscondingController@terminatestaff')->name('abscondings.terminatestaff');
    Route::get('abscondings/{id}/hold_staff', 'AbscondingController@holdstaff')->name('abscondings.holdstaff');

    // Route::get('offboarding', 'OffboardingController@index')->name('offbording.index');
    Route::post('resignation/approval', 'ResignationController@approval')->name('resignations.approval');

    Route::post('/resignation/retraction','ResignationController@retraction')->name('retraction.save');
    Route::post('/resignation/retraction_approval','ResignationStaffController@retraction_approval')->name('retraction.approval');
    
});