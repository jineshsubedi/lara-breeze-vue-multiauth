<?php

namespace App\Observers;

use App\Models\FiscalYear;

class FiscalYearObserver
{
    /**
     * Handle the FiscalYear "created" event.
     *
     * @param  \App\Models\FiscalYear  $fiscalYear
     * @return void
     */
    public function created(FiscalYear $fiscalyear)
    {
        $this->updateCurrentYear($fiscalyear);
    }

    private function updateCurrentYear($fiscalyear)
    {
        if($fiscalyear->current_year == '1')
        {
            FiscalYear::where('id', '!=', $fiscalyear->id)->where('current_year', '1')->update(['current_year' => '0']);
        }
    }

    /**
     * Handle the FiscalYear "updated" event.
     *
     * @param  \App\Models\FiscalYear  $fiscalYear
     * @return void
     */
    public function updated(FiscalYear $fiscalyear)
    {
        $this->updateCurrentYear($fiscalyear);
    }

    /**
     * Handle the FiscalYear "deleted" event.
     *
     * @param  \App\Models\FiscalYear  $fiscalYear
     * @return void
     */
    public function deleted(FiscalYear $fiscalyear)
    {
        //
    }

    /**
     * Handle the FiscalYear "restored" event.
     *
     * @param  \App\Models\FiscalYear  $fiscalYear
     * @return void
     */
    public function restored(FiscalYear $fiscalyear)
    {
        //
    }

    /**
     * Handle the FiscalYear "force deleted" event.
     *
     * @param  \App\Models\FiscalYear  $fiscalYear
     * @return void
     */
    public function forceDeleted(FiscalYear $fiscalyear)
    {
        //
    }
}
