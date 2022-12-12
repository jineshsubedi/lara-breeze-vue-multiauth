<?php 

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::prefix('profile')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::post('/', 'updateProfile')->name('updateProfile');
    Route::post('/avatar', 'updateAvatar')->name('updateAvatar');
    Route::delete('{id}/document', 'deleteProfileDocument')->name('deleteProfileDocument');
});

Route::resource('setting', 'SettingController')->only(['index', 'update']);

// Route::resource('roles', 'RoleController');
Route::resource('users', 'UsersController');

Route::resource('dailytasks', 'DailyTaskController');
Route::resource('branches', 'BranchController');

Route::get('branch/{id}/setting', 'BranchController@getSetting')->name('branch.getSetting');
Route::post('branch/{id}/setting', 'BranchController@storeSetting')->name('branch.storeSetting');

Route::resource('departments', 'DepartmentController');
Route::resource('designations', 'DesignationController');
Route::resource('shift_times', 'ShifttimeController');

Route::resource('leave_types', 'LeavetypeController');
Route::resource('leave_setting', 'LeavesettingController');
Route::resource('leaves', 'LeaveController')->only(['index', 'create', 'show', 'store', 'destroy']);
Route::patch('leaves/{id}/approval','LeaveController@approval')->name('leaves.approval');
Route::resource('fiscalyears', 'FiscalYearController');
Route::resource('compensatory', 'CompensatoryOffController');
Route::post('compensatory/approve/{compensatory}', 'CompensatoryOffController@approval')->name('compensatory.approval');

Route::get('/handovers', 'LeaveHandoverController@index')->name('handovers.index');
Route::post('/handovers/acceptAll', 'LeaveHandoverController@acceptAll')->name('handovers.accept');

Route::get('/calender', 'CalendarController@index')->name('calendar');
Route::resource('/notices', 'NoticeController');