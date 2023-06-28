<?php

namespace Hris\Offboarding;

use Hris\Offboarding\Observers\ResignationRetractionObserver;
use Hris\Offboarding\Models\Absconding;
use Hris\Offboarding\Models\DisciplinaryAction;
use Hris\Offboarding\Models\ResignationRetraction;
use Hris\Offboarding\Models\ResignationStaff;
use Hris\Offboarding\Models\TerminationStaff;
use Hris\Offboarding\Observers\AbscondingObserver;
use Hris\Offboarding\Observers\DisciplinaryActionObserver;
use Hris\Offboarding\Observers\ResignationStaffObserver;
use Hris\Offboarding\Observers\TerminationStaffObserver;
use Illuminate\Support\ServiceProvider;

class OffboardingServiceProvider extends ServiceProvider
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
            __DIR__.'/config/Constant.php', 'offboardConstant'
        );
        Absconding::observe(AbscondingObserver::class);
        TerminationStaff::observe(TerminationStaffObserver::class);
        ResignationStaff::observe(ResignationStaffObserver::class);
        DisciplinaryAction::observe(DisciplinaryActionObserver::class);
        ResignationRetraction::observe(ResignationRetractionObserver::class);
    }
}
