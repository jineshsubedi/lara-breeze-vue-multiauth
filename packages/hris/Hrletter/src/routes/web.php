<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Hrletter\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('lettertypes', 'LetterTypeController');
    Route::resource('letters', 'LetterController');
    Route::post('letter/{id}/generate', 'LetterController@generate');

});

Route::group([
    'namespace' => 'Hris\Hrletter\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('lettertypes', 'LetterTypeController');

});

Route::group([
    'namespace' => 'Hris\Hrletter\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('lettertypes', 'LetterTypeController');
    
});