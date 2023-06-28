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

Route::get('/', 'Front\LandingPageController@index')->name('front.landing.index');

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
    Route::post('getDepartmentByBranch', 'Common\CommonController@getDepartmentByBranch')->name('getDepartmentByBranch');
    Route::post('getStaffByDepartment', 'Common\CommonController@getStaffByDepartment')->name('getStaffByDepartment');
    Route::post('getShiftsByBranch', 'Common\CommonController@getShiftsByBranch')->name('getShiftsByBranch');
    Route::post('getDepartmentsByBranch', 'Common\CommonController@getDepartmentsByBranch')->name('getDepartmentsByBranch');
    Route::post('getDesignationByDepartment', 'Common\CommonController@getDesignationByDepartment')->name('getDesignationByDepartment');
    Route::post('getSubOrdinates', 'Common\CommonController@getSubOrdinates')->name('getSubOrdinates');
    Route::post('getStaffsKra', 'Common\CommonController@getStaffsKra')->name('getStaffsKra');
    Route::post('/mark-as-read', 'Common\CommonController@markNotification')->name('markNotification');

    Route::get('getYear', 'Common\CommonDateController@getYear')->name('getYear');
    Route::get('getMonth', 'Common\CommonDateController@getMonth')->name('getMonth');
    Route::get('getDays', 'Common\CommonDateController@getDays')->name('getDays');
    
    Route::get('calendar/events', 'Common\CalendarController@getEvents')->name('calendar.events');

    Route::post('getHallByPlaceId', 'Common\CommonController@getHallByPlaceId')->name('getHallByPlaceId');
    Route::post('getFacultyByEducationId', 'Common\CommonController@getFacultyByEducationId')->name('getFacultyByEducationId');
});