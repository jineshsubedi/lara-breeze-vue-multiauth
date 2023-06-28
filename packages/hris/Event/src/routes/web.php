<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Event\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('events', 'EventController');

});

Route::group([
    'namespace' => 'Hris\Event\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('events', 'EventController');

});

Route::group([
    'namespace' => 'Hris\Event\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('events', 'EventController');
    
});