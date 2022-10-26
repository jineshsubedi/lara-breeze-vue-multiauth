<?php 

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::prefix('profile')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::post('/', 'updateProfile')->name('updateProfile');
    Route::post('/avatar', 'updateAvatar')->name('updateAvatar');
    Route::delete('{id}/document', 'deleteProfileDocument')->name('deleteProfileDocument');
});

Route::resource('attendances', 'AttendanceController');
Route::post('attendance_approval', 'AttendanceController@approveAll')->name('attendances.approveAll');
Route::patch('attendances/{id}/approve','AttendanceController@approve')->name('attendances.approve');
Route::patch('attendances/{id}/reject','AttendanceController@reject')->name('attendances.reject');

Route::resource('dailytasks', 'DailyTaskController');