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
    Route::get('letter/generate', 'LetterController@generate')->name('letters.generate');
    Route::post('letter_generation', 'LetterController@letter_generation')->name('letters.generation');

});

Route::group([
    'namespace' => 'Hris\Hrletter\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('lettertypes', 'LetterTypeController');
    Route::resource('letters', 'LetterController');
    Route::get('letter/generate', 'LetterController@generate')->name('letters.generate');
    Route::post('letter_generation', 'LetterController@letter_generation')->name('letters.generation');

});

Route::group([
    'namespace' => 'Hris\Hrletter\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('lettertypes', 'LetterTypeController');
    Route::resource('letters', 'LetterController');
    Route::get('letter/generate', 'LetterController@generate')->name('letters.generate');
    Route::post('letter_generation', 'LetterController@letter_generation')->name('letters.generation');
    
});