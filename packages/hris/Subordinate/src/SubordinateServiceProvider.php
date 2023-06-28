<?php

namespace Hris\Subordinate;

use Hris\Subordinate\Models\Subordinate;
use Hris\Subordinate\Observers\SubordinateObserver;
use Illuminate\Support\ServiceProvider;

class SubordinateServiceProvider extends ServiceProvider
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
        Subordinate::observe(SubordinateObserver::class);
    }
}
