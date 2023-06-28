<?php

namespace Hris\Offboarding\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Offboarding\Models\Absconding;
use Hris\Offboarding\Notifications\AbscondingNotification;
use Illuminate\Support\Facades\Notification;

class AbscondingObserver
{
    public function creating(Absconding $absconding)
    {
        $absconding->branch_id = auth()->user()->branch_id;
        $absconding->issued_by = auth()->id();
    }
    /**
     * Handle the Absconding "created" event.
     *
     * @param  \App\Models\Absconding  $absconding
     * @return void
     */
    public function created(Absconding $absconding)
    {
        $user = User::find($absconding->user_id);
        $message = 'Absconding Alert! Please Contact HR for more Information';
        $link = '';
        Notification::send($user, new AbscondingNotification($absconding, $message, $link));
    }

    /**
     * Handle the Absconding "updated" event.
     *
     * @param  \App\Models\Absconding  $absconding
     * @return void
     */
    public function updated(Absconding $absconding)
    {
        //
    }

    /**
     * Handle the Absconding "deleted" event.
     *
     * @param  \App\Models\Absconding  $absconding
     * @return void
     */
    public function deleted(Absconding $absconding)
    {
        //
    }

    /**
     * Handle the Absconding "restored" event.
     *
     * @param  \App\Models\Absconding  $absconding
     * @return void
     */
    public function restored(Absconding $absconding)
    {
        //
    }

    /**
     * Handle the Absconding "force deleted" event.
     *
     * @param  \App\Models\Absconding  $absconding
     * @return void
     */
    public function forceDeleted(Absconding $absconding)
    {
        //
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.disciplinary.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.disciplinary.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.disciplinary.show', $id);
        }
    }
}
