<?php

namespace Hris\Training;

use Hris\Training\Observers\TrainingParticipantObserver;
use Hris\Training\Models\Training;
use Hris\Training\Models\TrainingParticipant;
use Hris\Training\Observers\TrainingObserver;
use Illuminate\Support\ServiceProvider;

class TrainingServiceProvider extends ServiceProvider
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
            __DIR__.'/config/Constant.php', 'trainingConstant'
        );
        Training::observe(TrainingObserver::class);
        TrainingParticipant::observe(TrainingParticipantObserver::class);
    }
}
