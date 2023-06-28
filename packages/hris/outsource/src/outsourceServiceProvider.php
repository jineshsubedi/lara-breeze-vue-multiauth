<?php

namespace Hris\Outsource;

use Hris\Outsource\Models\Outsource;
use Hris\Outsource\Observers\OutsourceObserver;
use Illuminate\Support\ServiceProvider;

class OutsourceServiceProvider extends ServiceProvider
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
            __DIR__.'/config/Constant.php', 'outsourceConstant'
        );
        $this->loadViewsFrom(__DIR__.'/views', 'outsource');
        Outsource::observe(OutsourceObserver::class);
    }
}
