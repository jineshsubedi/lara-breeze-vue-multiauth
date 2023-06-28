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

    Route::get('mysurveys', 'SurveyAnswerController@index')->name('mysurveys.index');
    Route::get('mysurveys/{id}', 'SurveyAnswerController@show')->name('mysurveys.show');
    Route::post('mysurveys/{id}', 'SurveyAnswerController@store')->name('mysurveys.store');

    Route::get('surveys/{id}/applicants', 'SurveyController@participants')->name('surveys.participants');
    Route::get('surveys/{id}/applicants/{user_id}', 'SurveyController@participants_detail')->name('surveys.participants_detail');

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
    Route::delete('survey_question/{id}', 'SurveyController@deleteQuestion')->name('surveys.deleteQuestion');
    Route::post('survey_question/{id}', 'SurveyController@autocomplete')->name('surveys.autocomplete');
    Route::post('survey_question/bulk/{id}', 'SurveyController@bulkimport')->name('surveys.bulkimport');
    
    Route::get('mysurveys', 'SurveyAnswerController@index')->name('mysurveys.index');
    Route::get('mysurveys/{id}', 'SurveyAnswerController@show')->name('mysurveys.show');
    Route::post('mysurveys/{id}', 'SurveyAnswerController@store')->name('mysurveys.store');

    Route::get('surveys/{id}/applicants', 'SurveyController@participants')->name('surveys.participants');
    Route::get('surveys/{id}/applicants/{user_id}', 'SurveyController@participants_detail')->name('surveys.participants_detail');
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
    Route::delete('survey_question/{id}', 'SurveyController@deleteQuestion')->name('surveys.deleteQuestion');
    Route::post('survey_question/{id}', 'SurveyController@autocomplete')->name('surveys.autocomplete');
    Route::post('survey_question/bulk/{id}', 'SurveyController@bulkimport')->name('surveys.bulkimport');
    
    Route::get('mysurveys', 'SurveyAnswerController@index')->name('mysurveys.index');
    Route::get('mysurveys/{id}', 'SurveyAnswerController@show')->name('mysurveys.show');
    Route::post('mysurveys/{id}', 'SurveyAnswerController@store')->name('mysurveys.store');

    Route::get('surveys/{id}/applicants', 'SurveyController@participants')->name('surveys.participants');
    Route::get('surveys/{id}/applicants/{user_id}', 'SurveyController@participants_detail')->name('surveys.participants_detail');
});