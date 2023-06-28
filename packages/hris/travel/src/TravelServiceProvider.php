<?php

namespace Hris\Travel;

use Hris\Travel\Models\Travel;
use Hris\Travel\Models\TravelExpense;
use Hris\Travel\Observers\TravelExpenseObserver;
use Hris\Travel\Observers\TravelObserver;
use Illuminate\Support\ServiceProvider;

class TravelServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(
            __DIR__.'/config/Constant.php', 'travelConstant'
        );
        Travel::observe(TravelObserver::class);
        TravelExpense::observe(TravelExpenseObserver::class);
    }
}
