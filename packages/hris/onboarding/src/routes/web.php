<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Onboarding\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('onboardings', 'OnBoardStaffController');
    Route::post('onboard_staff', 'OnBoardStaffController@approve')->name('onboardings.approve');

});

Route::group([
    'namespace' => 'Hris\Onboarding\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    // Route::resource('onboardings', 'OnboardingController');

});

Route::group([
    'namespace' => 'Hris\Onboarding\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    // Route::resource('onboardings', 'OnboardingController');
    
});