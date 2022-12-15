<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Survey\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('surveys', 'SurveyController');
    Route::get('survey/{id}/question', 'SurveyController@getQuestion')->name('surveys.getQuestion');
    Route::post('survey/{id}/question', 'SurveyController@postQuestion')->name('surveys.postQuestion');
    Route::delete('survey_question/{id}', 'SurveyController@deleteQuestion')->name('surveys.deleteQuestion');
    Route::post('survey_question/{id}', 'SurveyController@autocomplete')->name('surveys.autocomplete');
    Route::post('survey_question/bulk/{id}', 'SurveyController@bulkimport')->name('surveys.bulkimport');

});

Route::group([
    'namespace' => 'Hris\Survey\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('surveys', 'SurveyController');
    Route::get('survey/{id}/question', 'SurveyController@getQuestion')->name('surveys.getQuestion');
    Route::post('survey/{id}/question', 'SurveyController@postQuestion')->name('surveys.postQuestion');
    
    
});

Route::group([
    'namespace' => 'Hris\Survey\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('surveys', 'SurveyController');
    Route::get('survey/{id}/question', 'SurveyController@getQuestion')->name('surveys.getQuestion');
    Route::post('survey/{id}/question', 'SurveyController@postQuestion')->name('surveys.postQuestion');
    
});