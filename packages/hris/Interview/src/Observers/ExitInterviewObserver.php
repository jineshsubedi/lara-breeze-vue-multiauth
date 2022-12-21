<?php

namespace Hris\Interview\Observers;

use Hris\Interview\Models\ExitInterview;

class ExitInterviewObserver
{
    public function creating(ExitInterview $exitInterview)
    {
        $exitInterview->branch_id = auth()->user()->branch_id;
    }
    /**
     * Handle the ExitInterview "created" event.
     *
     * @param  \App\Models\ExitInterview  $exitInterview
     * @return void
     */
    public function created(ExitInterview $exitInterview)
    {
        //
    }

    /**
     * Handle the ExitInterview "updated" event.
     *
     * @param  \App\Models\ExitInterview  $exitInterview
     * @return void
     */
    public function updated(ExitInterview $exitInterview)
    {
        //
    }

    /**
     * Handle the ExitInterview "deleted" event.
     *
     * @param  \App\Models\ExitInterview  $exitInterview
     * @return void
     */
    public function deleted(ExitInterview $exitInterview)
    {
        //
    }

    /**
     * Handle the ExitInterview "restored" event.
     *
     * @param  \App\Models\ExitInterview  $exitInterview
     * @return void
     */
    public function restored(ExitInterview $exitInterview)
    {
        //
    }

    /**
     * Handle the ExitInterview "force deleted" event.
     *
     * @param  \App\Models\ExitInterview  $exitInterview
     * @return void
     */
    public function forceDeleted(ExitInterview $exitInterview)
    {
        //
    }
}
