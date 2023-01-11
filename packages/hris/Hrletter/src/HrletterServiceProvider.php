<?php

namespace Hris\Hrletter;

use Illuminate\Support\ServiceProvider;

class HrletterServiceProvider extends ServiceProvider
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
            __DIR__.'/config/Constant.php', 'letterConstant'
        );
        $this->loadViewsFrom(__DIR__.'/views', 'letter');
    }
}
