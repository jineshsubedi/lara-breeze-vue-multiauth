<?php

namespace App\Observers;

use App\Models\Jobs;

class JobsObserver
{
    /**
     * Handle the Jobs "created" event.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return void
     */
    public function created(Jobs $jobs)
    {
        //
    }

    /**
     * Handle the Jobs "updated" event.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return void
     */
    public function updated(Jobs $jobs)
    {
        //
    }

    /**
     * Handle the Jobs "deleted" event.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return void
     */
    public function deleted(Jobs $jobs)
    {
        //
    }

    /**
     * Handle the Jobs "restored" event.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return void
     */
    public function restored(Jobs $jobs)
    {
        //
    }

    /**
     * Handle the Jobs "force deleted" event.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return void
     */
    public function forceDeleted(Jobs $jobs)
    {
        //
    }
}
