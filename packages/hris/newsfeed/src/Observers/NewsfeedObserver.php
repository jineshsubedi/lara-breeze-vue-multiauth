<?php

namespace Hris\Newsfeed\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Newsfeed\Enums\NewsfeedEvent;
use Hris\Newsfeed\Models\Newsfeed;
use Hris\Newsfeed\Notifications\NewsfeedNotification;
use Illuminate\Support\Facades\Notification;

class NewsfeedObserver
{
    public function creating(Newsfeed $newsfeed)
    {
        $newsfeed->user_id = auth()->id();
        $newsfeed->branch_id = auth()->user()->branch_id;
    }
    /**
     * Handle the Newsfeed "created" event.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return void
     */
    public function created(Newsfeed $newsfeed)
    {
        $newsfeed->load(['user:id,name']);
        if($newsfeed->to_staff != null && $newsfeed->event_category != NULL)
        {
            $title = '';
            if($newsfeed->event_category == NewsfeedEvent::BIRTHDAY->value)
                $title = 'BIRTHDAY';
            elseif($newsfeed->event_category == NewsfeedEvent::ANNIVERSARY->value)
                $title = 'ANNIVERSARY';
            elseif($newsfeed->event_category == NewsfeedEvent::ACHIEVEMENT->value)
                $title = 'ACHIEVEMENT';
            elseif($newsfeed->event_category == NewsfeedEvent::PROMOTION->value)
                $title = 'PROMOTION';
            elseif($newsfeed->event_category == NewsfeedEvent::MARRIAGE->value)
                $title = 'MARRIAGE';

            $user = User::select('id', 'name', 'staff_type')->find($newsfeed->to_staff);
            $message = $newsfeed->user->name.' Has Created your '.$title.' Post';
            $link = $this->staffUrl($user, $newsfeed->id);
            Notification::send($user, new NewsfeedNotification($newsfeed, $message, $link));
        }
    }

    /**
     * Handle the Newsfeed "updated" event.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return void
     */
    public function updated(Newsfeed $newsfeed)
    {
        //
    }

    /**
     * Handle the Newsfeed "deleted" event.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return void
     */
    public function deleted(Newsfeed $newsfeed)
    {
        //
    }

    /**
     * Handle the Newsfeed "restored" event.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return void
     */
    public function restored(Newsfeed $newsfeed)
    {
        //
    }

    /**
     * Handle the Newsfeed "force deleted" event.
     *
     * @param  \App\Models\Newsfeed  $newsfeed
     * @return void
     */
    public function forceDeleted(Newsfeed $newsfeed)
    {
        //
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.newsfeeds.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.newsfeeds.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.newsfeeds.show', $id);
        }
    }
}
