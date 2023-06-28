<?php

namespace Hris\Attendance;

use Hris\Attendance\Models\Attendance;
use Hris\Attendance\Observers\AttendanceObserver;
use Illuminate\Support\ServiceProvider;

class AttendanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'attendance');
        Attendance::observe(AttendanceObserver::class);
    }
}
