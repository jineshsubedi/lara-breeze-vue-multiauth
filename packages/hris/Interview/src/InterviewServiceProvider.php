<?php

namespace Hris\Interview;

use Hris\Interview\Observers\ExitInterviewObserver;
use Hris\Interview\Models\ExitInterview;
use Illuminate\Support\ServiceProvider;

class InterviewServiceProvider extends ServiceProvider
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

        ExitInterview::observe(ExitInterviewObserver::class);
    }
}
