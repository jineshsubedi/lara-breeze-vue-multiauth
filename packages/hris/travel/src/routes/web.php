<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Travel\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('assignmenttypes', 'AssignmentTypeController');
    Route::resource('assignmentcategories', 'AssignmentCategoryController');

    Route::resource('travels', 'TravelController');
    Route::resource('travelplanners', 'TravelPlannerController');

    Route::post('/travel_approval','TravelController@approval')->name('travels.approval');
    Route::post('/travelplanners_approval/{id}','TravelPlannerController@approval')->name('travelplanners.approval');

    Route::post('travel_expenses/{id}', 'TravelExpenseController@saveTravelExpense')->name('travels.saveTravelExpense');
    Route::delete('travel_expenses/{id}', 'TravelExpenseController@deleteTravelExpense')->name('travels.deleteTravelExpense');

    Route::post('travel_replies/{id}', 'TravelController@saveReply')->name('travels.saveReply');

});

Route::group([
    'namespace' => 'Hris\Travel\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('assignmenttypes', 'AssignmentTypeController');
    Route::resource('assignmentcategories', 'AssignmentCategoryController');

    Route::resource('travels', 'TravelController');
    Route::resource('travelplanners', 'TravelPlannerController');

    Route::post('/travel_approval','TravelController@approval')->name('travels.approval');
    Route::post('/travelplanners_approval/{id}','TravelPlannerController@approval')->name('travelplanners.approval');

    Route::post('travel_expenses/{id}', 'TravelExpenseController@saveTravelExpense')->name('travels.saveTravelExpense');
    Route::delete('travel_expenses/{id}', 'TravelExpenseController@deleteTravelExpense')->name('travels.deleteTravelExpense');

    Route::post('travel_replies/{id}', 'TravelController@saveReply')->name('travels.saveReply');

});

Route::group([
    'namespace' => 'Hris\Travel\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('assignmenttypes', 'AssignmentTypeController');
    Route::resource('assignmentcategories', 'AssignmentCategoryController');

    Route::resource('travels', 'TravelController');
    Route::resource('travelplanners', 'TravelPlannerController');

    Route::post('/travel_approval','TravelController@approval')->name('travels.approval');
    Route::post('/travelplanners_approval/{id}','TravelPlannerController@approval')->name('travelplanners.approval');

    Route::post('travel_expenses/{id}', 'TravelExpenseController@saveTravelExpense')->name('travels.saveTravelExpense');
    Route::delete('travel_expenses/{id}', 'TravelExpenseController@deleteTravelExpense')->name('travels.deleteTravelExpense');

    Route::post('travel_replies/{id}', 'TravelController@saveReply')->name('travels.saveReply');
    
});