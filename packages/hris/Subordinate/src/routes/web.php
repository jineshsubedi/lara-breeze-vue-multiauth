<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Subordinate\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('subordinates', 'SubordinateController');

});

Route::group([
    'namespace' => 'Hris\Subordinate\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('subordinates', 'SubordinateController');

});

Route::group([
    'namespace' => 'Hris\Subordinate\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('subordinates', 'SubordinateController');
    
});