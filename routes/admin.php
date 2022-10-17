<?php 

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('dashboard', function(){
    return Inertia::render('Admin/Dashboard');
})->name('dashboard');

Route::prefix('profile')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::post('/', 'updateProfile')->name('updateProfile');
    Route::post('/avatar', 'updateAvatar')->name('updateAvatar');
});

Route::resource('setting', 'SettingController')->only(['index', 'update']);
