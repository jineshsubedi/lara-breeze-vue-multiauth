<?php

namespace Hris\Dummy\Observers;

use App\Models\User;
use Hris\Dummy\Models\Dummy;
use Illuminate\Support\Facades\Notification;
use Hris\Dummy\Notifications\DummyNotification;

class DummyObserver
{
    /**
     * Handle the Dummy "created" event.
     *
     * @param  Hris\Dummy\Models\Dummy  $dummies
     * @return void
     */
    public function created(Dummy $dummies)
    {
        //
    }

    /**
     * Handle the Dummy "updated" event.
     *
     * @param  Hris\Dummy\Models\Dummy  $dummies
     * @return void
     */
    public function updated(Dummy $dummies)
    {
        //
    }

    /**
     * Handle the Dummy "deleted" event.
     *
     * @param  Hris\Dummy\Models\Dummy  $dummies
     * @return void
     */
    public function deleted(Dummy $dummies)
    {
        //
    }

    /**
     * Handle the Dummy "restored" event.
     *
     * @param  Hris\Dummy\Models\Dummy  $dummies
     * @return void
     */
    public function restored(Dummy $dummies)
    {
        //
    }

    /**
     * Handle the Dummy "force deleted" event.
     *
     * @param  Hris\Dummy\Models\Dummy  $dummies
     * @return void
     */
    public function forceDeleted(Dummy $dummies)
    {
        //
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.dummies.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.dummies.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.dummies.show', $id);
        }
    }
}
