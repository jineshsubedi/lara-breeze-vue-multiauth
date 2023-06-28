<?php

namespace Hris\Adjustment;

use Hris\Adjustment\Models\Adjustment;
use Hris\Adjustment\Observers\AdjustmentObserver;
use Illuminate\Support\ServiceProvider;

class AdjustmentServiceProvider extends ServiceProvider
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
        Adjustment::observe(AdjustmentObserver::class);
    }
}
