<?php 

use Illuminate\Support\Facades\Route;

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::prefix('profile')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::post('/', 'updateProfile')->name('updateProfile');
    Route::post('/avatar', 'updateAvatar')->name('updateAvatar');
    Route::delete('{id}/document', 'deleteProfileDocument')->name('deleteProfileDocument');
});

Route::resource('dailytasks', 'DailyTaskController');
Route::post('dailytasks_approve', 'DailyTaskController@approve')->name('dailytasks.approve');
Route::post('dailytasks_approveById/{id}', 'DailyTaskController@approveById')->name('dailytasks.approveById');

Route::resource('users', 'UsersController');

Route::resource('leaves', 'LeaveController')->only(['index', 'create', 'show', 'store', 'destroy']);
Route::patch('leaves/{id}/approval','LeaveController@approval')->name('leaves.approval');
Route::resource('fiscalyears', 'FiscalYearController');
Route::resource('compensatory', 'CompensatoryOffController');
Route::post('compensatory/approve/{compensatory}', 'CompensatoryOffController@approval')->name('compensatory.approval');

Route::get('/handovers', 'LeaveHandoverController@index')->name('handovers.index');
Route::post('/handovers/acceptAll', 'LeaveHandoverController@acceptAll')->name('handovers.accept');

Route::get('/calender', 'CalendarController@index')->name('calendar');
Route::resource('/notices', 'NoticeController');

Route::get('/organization_chart', 'OrgChartController@index')->name('organization_chart');

Route::resource('education', 'EducationController');
Route::resource('faculties', 'FacultyController');

Route::get('reports/{id}', 'ReportController@index')->name('reports.index');
Route::get('reports/calendar/{id}', 'ReportController@calendar')->name('calendar.index');

Route::post('kpis/{id}', 'ProfileController@saveKpi')->name('kpis.store');
Route::delete('kpis/{id}', 'ProfileController@deleteKpi')->name('kpis.destroy');
Route::post('kras/{id}', 'ProfileController@saveKra')->name('kras.store');
Route::delete('kras/{id}', 'ProfileController@deleteKra')->name('kras.destroy');