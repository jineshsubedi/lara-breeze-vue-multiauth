<?php

namespace Hris\Subordinate\Observers;

use App\Models\User;
use Hris\Subordinate\Models\Subordinate;
use Hris\Subordinate\Notifications\SubordinateNotification;
use Illuminate\Support\Facades\Notification;

class SubordinateObserver
{
    public function creating(Subordinate $subordinate)
    {
        $subordinate->branch_id = auth()->user()->branch_id;
        $subordinate->user_id = auth()->id();
        $subordinate->supervisor = auth()->user()->supervisor_id;
    }
    /**
     * Handle the Subordinate "created" event.
     *
     * @param  \App\Models\Subordinate  $subordinate
     * @return void
     */
    public function created(Subordinate $subordinate)
    {
        $this->fetchSubordinateNotification($subordinate);
    }

    protected function fetchSubordinateNotification($subordinate)
    {
        $user = User::select('id', 'name', 'staff_type')->find($subordinate->supervisor);
        $link = $this->staffUrl($user, $subordinate->id);
        $message = strip_tags($subordinate->description);
        Notification::send($user, new SubordinateNotification($subordinate, $message, $link));
    }

    /**
     * Handle the Subordinate "updated" event.
     *
     * @param  \App\Models\Subordinate  $subordinate
     * @return void
     */
    public function updated(Subordinate $subordinate)
    {
        //
    }

    /**
     * Handle the Subordinate "deleted" event.
     *
     * @param  \App\Models\Subordinate  $subordinate
     * @return void
     */
    public function deleted(Subordinate $subordinate)
    {
        //
    }

    /**
     * Handle the Subordinate "restored" event.
     *
     * @param  \App\Models\Subordinate  $subordinate
     * @return void
     */
    public function restored(Subordinate $subordinate)
    {
        //
    }

    /**
     * Handle the Subordinate "force deleted" event.
     *
     * @param  \App\Models\Subordinate  $subordinate
     * @return void
     */
    public function forceDeleted(Subordinate $subordinate)
    {
        //
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.subordinates.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.subordinates.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.subordinates.show', $id);
        }
    }
}
