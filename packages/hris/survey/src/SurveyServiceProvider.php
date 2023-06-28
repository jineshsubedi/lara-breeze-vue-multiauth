<?php

namespace Hris\Survey;

use Hris\Survey\Models\Survey;
use Hris\Survey\Observers\SurveyObserver;
use Illuminate\Support\ServiceProvider;

class SurveyServiceProvider extends ServiceProvider
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
        Survey::observe(SurveyObserver::class);
    }
}
