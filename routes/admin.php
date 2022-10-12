<?php 

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('dashboard', function(){
    return Inertia::render('Admin/Dashboard');
})->name('dashboard');

Route::resource('setting', 'SettingController')->only(['index', 'update']);
