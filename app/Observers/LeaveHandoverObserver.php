<?php

namespace App\Observers;

use App\Models\LeaveHandover;
use App\Models\User;
use App\Notifications\LeaveHandoverNotification;
use Illuminate\Support\Facades\Notification;

class LeaveHandoverObserver
{
    /**
     * Handle the LeaveHandover "created" event.
     *
     * @param  \App\Models\LeaveHandover  $leaveHandover
     * @return void
     */
    public function created(LeaveHandover $leaveHandover)
    {
        $leaveHandover->load(['user:id,name']);
        $user = User::find($leaveHandover->user_id);
        $message = auth()->user()->name.' Has Requested a Handover Request';
        $link = $this->staffUrl($user, $leaveHandover->id);
        Notification::send($user, new LeaveHandoverNotification($leaveHandover, $message, $link));
    }

    /**
     * Handle the LeaveHandover "updated" event.
     *
     * @param  \App\Models\LeaveHandover  $leaveHandover
     * @return void
     */
    public function updated(LeaveHandover $leaveHandover)
    {
        $this->changeStatus(($leaveHandover));
    }
    private function changeStatus($leaveHandover)
    {
        if($leaveHandover->isDirty('status') && $leaveHandover->status == '1'){
            $leaveHandover->load('leave');
            if($leaveHandover->leave){
                $user = User::find($leaveHandover->leave->user_id);
                $message = auth()->user()->name.' Has Approved Your Handover Request';
                $link = $this->staffUrl($user, $leaveHandover->id);
                Notification::send($user, new LeaveHandoverNotification($leaveHandover, $message, $link));
            }
        }
    }

    /**
     * Handle the LeaveHandover "deleted" event.
     *
     * @param  \App\Models\LeaveHandover  $leaveHandover
     * @return void
     */
    public function deleted(LeaveHandover $leaveHandover)
    {
        //
    }

    /**
     * Handle the LeaveHandover "restored" event.
     *
     * @param  \App\Models\LeaveHandover  $leaveHandover
     * @return void
     */
    public function restored(LeaveHandover $leaveHandover)
    {
        //
    }

    /**
     * Handle the LeaveHandover "force deleted" event.
     *
     * @param  \App\Models\LeaveHandover  $leaveHandover
     * @return void
     */
    public function forceDeleted(LeaveHandover $leaveHandover)
    {
        //
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.handovers.index');
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.handovers.index');
        }
        if($user->staff_type == 3)
        {
            return route('staffs.handovers.index');
        }
    }
}
