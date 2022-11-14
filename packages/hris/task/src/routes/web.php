<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Task\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('tasks', 'TaskController');
    Route::post('task/jobs/{id}', 'TaskController@saveJobs')->name('taskjobs.save');
    Route::delete('task/jobs/{id}', 'TaskController@deleteJobs')->name('taskjobs.delete');
});

Route::group([
    'namespace' => 'Hris\Task\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('tasks', 'TaskController');
    Route::post('task/jobs/{id}', 'TaskController@saveJobs')->name('taskjobs.save');
    Route::delete('task/jobs/{id}', 'TaskController@deleteJobs')->name('taskjobs.delete');
});

Route::group([
    'namespace' => 'Hris\Task\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('tasks', 'TaskController');
    Route::post('task/jobs/{id}', 'TaskController@saveJobs')->name('taskjobs.save');
    Route::delete('task/jobs/{id}', 'TaskController@deleteJobs')->name('taskjobs.delete');
});