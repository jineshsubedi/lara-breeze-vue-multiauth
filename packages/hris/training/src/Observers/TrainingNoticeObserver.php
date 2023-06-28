<?php

namespace Hris\Training\Observers;

use Hris\Training\Models\TrainingNotice;

class TrainingNoticeObserver
{
    /**
     * Handle the TrainingNotice "created" event.
     *
     * @param  \App\Models\TrainingNotice  $trainingNotice
     * @return void
     */
    public function created(TrainingNotice $trainingNotice)
    {
        //
    }

    /**
     * Handle the TrainingNotice "updated" event.
     *
     * @param  \App\Models\TrainingNotice  $trainingNotice
     * @return void
     */
    public function updated(TrainingNotice $trainingNotice)
    {
        //
    }

    /**
     * Handle the TrainingNotice "deleted" event.
     *
     * @param  \App\Models\TrainingNotice  $trainingNotice
     * @return void
     */
    public function deleted(TrainingNotice $trainingNotice)
    {
        //
    }

    /**
     * Handle the TrainingNotice "restored" event.
     *
     * @param  \App\Models\TrainingNotice  $trainingNotice
     * @return void
     */
    public function restored(TrainingNotice $trainingNotice)
    {
        //
    }

    /**
     * Handle the TrainingNotice "force deleted" event.
     *
     * @param  \App\Models\TrainingNotice  $trainingNotice
     * @return void
     */
    public function forceDeleted(TrainingNotice $trainingNotice)
    {
        //
    }
}
