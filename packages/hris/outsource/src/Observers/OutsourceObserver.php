<?php

namespace Hris\Outsource\Observers;

use Hris\Outsource\Models\Outsource;

class OutsourceObserver
{
    public function creating(Outsource $outsource)
    {
        $outsource->branch_id = auth()->user()->branch_id;
    }
    /**
     * Handle the Outsource "created" event.
     *
     * @param  \App\Models\Outsource  $outsource
     * @return void
     */
    public function created(Outsource $outsource)
    {
        //
    }

    /**
     * Handle the Outsource "updated" event.
     *
     * @param  \App\Models\Outsource  $outsource
     * @return void
     */
    public function updated(Outsource $outsource)
    {
        //
    }

    /**
     * Handle the Outsource "deleted" event.
     *
     * @param  \App\Models\Outsource  $outsource
     * @return void
     */
    public function deleted(Outsource $outsource)
    {
        //
    }

    /**
     * Handle the Outsource "restored" event.
     *
     * @param  \App\Models\Outsource  $outsource
     * @return void
     */
    public function restored(Outsource $outsource)
    {
        //
    }

    /**
     * Handle the Outsource "force deleted" event.
     *
     * @param  \App\Models\Outsource  $outsource
     * @return void
     */
    public function forceDeleted(Outsource $outsource)
    {
        //
    }
}
