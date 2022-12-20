<?php

namespace Hris\Overtime;

use Hris\Overtime\Models\Overtime;
use Hris\Overtime\Observers\OvertimeObserver;
use Illuminate\Support\ServiceProvider;

class OvertimeServiceProvider extends ServiceProvider
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
        Overtime::observe(OvertimeObserver::class);
    }
}
