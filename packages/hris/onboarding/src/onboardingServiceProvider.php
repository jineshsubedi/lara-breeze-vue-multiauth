<?php

namespace Hris\Onboarding;

use Hris\Onboarding\Models\OnBoardStaff;
use Hris\Onboarding\Observers\OnBoardStaffObserver;
use Illuminate\Support\ServiceProvider;

class OnboardingServiceProvider extends ServiceProvider
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
            __DIR__.'/config/Constant.php', 'onboardConstant'
        );
        OnBoardStaff::observe(OnBoardStaffObserver::class);
    }
}
