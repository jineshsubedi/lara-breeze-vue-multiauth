<?php

use App\Enums\StaffType;
use Illuminate\Foundation\Application;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

require __DIR__.'/auth.php';

Route::prefix('file-manager')->controller(FilemanagerController::class)->group(function () {
    Route::get('/directory', 'getFolderDirectory')->name('filemanager.index');
    Route::post('/upload-file', 'storeFile')->name('filemanager.upload_file');
    Route::post('/upload-folder', 'storeFolder')->name('filemanager.upload_folder');
    Route::post('/delete-file', 'deleteFile')->name('filemanager.delete_file');
    Route::post('/delete-folder', 'deleteFolder')->name('filemanager.delete_folder');
});

Route::prefix('common')->group(function() {
    Route::get('getDistrict', 'Common\CommonController@getDistrict')->name('getDistrict');
    Route::post('getStaffsByBranch', 'Common\CommonController@getStaffsByBranch')->name('getStaffsByBranch');
});