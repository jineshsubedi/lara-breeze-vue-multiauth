<?php

namespace App\Observers;

use App\Enums\StaffType;
use App\Models\Branch;
use App\Models\User;
use App\Models\UserAddress;
use App\Notifications\NewUserNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    public function creating(User $user)
    {
        if(request()->probation > 0)
            $user->provision_end_date = Carbon::parse($user->join_date)->addMonths(request()->probation);
    }
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
    */
    public function created(User $user)
    {
        if ($user->staff_type == StaffType::ADMIN->value && Branch::find($user->branch_id)->is_head == 1) {
            $user->assignRole('SuperAdmin');
        }
        UserAddress::create([
            'user_id' => $user->id,
            'primary_location' => request()->primary_location
        ]);
        $message = 'Dear <b>'.$user->name.'</b> you are welcome to HRIS system';
        $link = '';
        Notification::send($user, new NewUserNotification($user, $message, $link));
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if ($user->staff_type == StaffType::ADMIN->value && Branch::find($user->branch_id)->is_head == 1) {
            $user->assignRole('SuperAdmin');
        }else{
            $user->removeRole('SuperAdmin');
        }   
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
