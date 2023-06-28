<?php

namespace Hris\Revenue\Observers;

use Hris\Revenue\Models\Revenue;

class RevenueObserver
{
    /**
     * Handle the Revenue "created" event.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return void
     */
    public function created(Revenue $revenue)
    {
        //
    }

    /**
     * Handle the Revenue "updated" event.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return void
     */
    public function updated(Revenue $revenue)
    {
        //
    }

    /**
     * Handle the Revenue "deleted" event.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return void
     */
    public function deleted(Revenue $revenue)
    {
        //
    }

    /**
     * Handle the Revenue "restored" event.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return void
     */
    public function restored(Revenue $revenue)
    {
        //
    }

    /**
     * Handle the Revenue "force deleted" event.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return void
     */
    public function forceDeleted(Revenue $revenue)
    {
        //
    }
}
