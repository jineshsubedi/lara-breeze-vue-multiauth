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
Route::post('dailytasks_approve', 'DailyTaskController@approve')->name('dailytasks.approve');
Route::post('dailytasks_approveById/{id}', 'DailyTaskController@approveById')->name('dailytasks.approveById');
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

Route::get('/organization_chart', 'OrgChartController@index')->name('organization_chart');

Route::resource('education', 'EducationController');
Route::resource('faculties', 'FacultyController');

Route::get('reports/{id}', 'ReportController@index')->name('reports.index');
Route::get('reports/calendar/{id}', 'ReportController@calendar')->name('calendar.index');

Route::post('kpis/{id}', 'ProfileController@saveKpi')->name('kpis.store');
Route::delete('kpis/{id}', 'ProfileController@deleteKpi')->name('kpis.destroy');
Route::post('kras/{id}', 'ProfileController@saveKra')->name('kras.store');
Route::delete('kras/{id}', 'ProfileController@deleteKra')->name('kras.destroy');

// jobs
Route::resource('joblevels','JobLevelController');
Route::resource('joblocations','JobLocationController');
Route::resource('recruitmentprocesses','RecruitmentProcessController');
Route::resource('jobs','JobsController');
Route::post('jobs_autocomplete', 'JobsController@autocomplete')->name('jobs.autocomplete');
Route::post('jobs/addJobForm', 'JobsController@addJobForm')->name('jobs.addJobForm');
Route::post('jobs/deleteJobForm', 'JobsController@deleteJobForm')->name('jobs.deleteJobForm');
Route::post('jobs/deleteForm', 'JobsController@deleteForm')->name('jobs.deleteForm');
Route::get('jobs/{id}/applicants', 'JobApplicantController@index')->name('jobs.applicants.index');
Route::post('jobs/{id}/applicants', 'JobApplicantController@update_candidate')->name('jobs.applicants.candidate_update');
Route::get('jobs/{id}/applicants/{applicant}', 'JobApplicantController@showApplicant')->name('jobs.applicants.show');
Route::post('jobs/{id}/application_process', 'JobApplicantController@application_process')->name('jobs.applicants.process_store');
Route::get('jobs/{id}/{process_id}/applicants', 'JobApplicantController@process')->name('jobs.applicants.processing');
Route::put('jobs/{id}/{process_id}/applicants', 'JobApplicantController@update_process')->name('jobs.applicants.process_update');
Route::delete('jobs/{id}/{process_id}', 'JobApplicantController@delete_process')->name('jobs.applicants.delete_process');
Route::get('jobs/{id}/cv', 'JobApplicantController@downloadCV')->name('jobs.applicants.allcv');
Route::get('jobs/{id}/cover', 'JobApplicantController@downloadCover')->name('jobs.applicants.allcover');

Route::post('/kpirating', 'OTStaffController@kpiRating')->name('kpirating');
Route::post('/subrating', 'OTStaffController@subRating')->name('subrating');
Route::post('/performanceRating', 'OTStaffController@performanceRating')->name('performancerating');
