<?php

namespace Hris\Offboarding\Observers;

use App\Models\User;
use Hris\Offboarding\Enums\TerminationStatus;
use Hris\Offboarding\Models\TerminationStaff;
use Hris\Offboarding\Notifications\TerminationStaffNotification;
use Illuminate\Support\Facades\Notification;

class TerminationStaffObserver
{
    public function creating(TerminationStaff $terminationStaff)
    {
        $terminationStaff->branch_id = auth()->user()->branch_id;
        $terminationStaff->start_date = Date('Y-m-d');
        $terminationStaff->end_date = Date('Y-m-d');
        $terminationStaff->terminate_by = auth()->id();
        $terminationStaff->status = TerminationStatus::TERMINATE->value;
    }
    /**
     * Handle the TerminationStaff "created" event.
     *
     * @param  \App\Models\TerminationStaff  $terminationStaff
     * @return void
     */
    public function created(TerminationStaff $terminationStaff)
    {
        $user = User::find($terminationStaff->user_id);
        $message = 'You Are Terminated! Please Check For Offboarding Date';
        $link = '';
        Notification::send($user, new TerminationStaffNotification($terminationStaff, $message, $link));
    }

    /**
     * Handle the TerminationStaff "updated" event.
     *
     * @param  \App\Models\TerminationStaff  $terminationStaff
     * @return void
     */
    public function updated(TerminationStaff $terminationStaff)
    {
        //
    }

    /**
     * Handle the TerminationStaff "deleted" event.
     *
     * @param  \App\Models\TerminationStaff  $terminationStaff
     * @return void
     */
    public function deleted(TerminationStaff $terminationStaff)
    {
        //
    }

    /**
     * Handle the TerminationStaff "restored" event.
     *
     * @param  \App\Models\TerminationStaff  $terminationStaff
     * @return void
     */
    public function restored(TerminationStaff $terminationStaff)
    {
        //
    }

    /**
     * Handle the TerminationStaff "force deleted" event.
     *
     * @param  \App\Models\TerminationStaff  $terminationStaff
     * @return void
     */
    public function forceDeleted(TerminationStaff $terminationStaff)
    {
        //
    }
}
