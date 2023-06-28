<?php

namespace Hris\Newsfeed\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Newsfeed\Models\NewsfeedLike;
use Hris\Newsfeed\Notifications\NewsfeedNotification;
use Illuminate\Support\Facades\Notification;

class NewsfeedLikeObserver
{
    /**
     * Handle the NewsfeedLike "created" event.
     *
     * @param  \App\Models\NewsfeedLike  $newsfeedLike
     * @return void
     */
    public function created(NewsfeedLike $newsfeedLike)
    {
        $newsfeedLike->load(['user:id,name', 'newsfeed:id,user_id']);
        if($newsfeedLike->user_id != $newsfeedLike->newsfeed->user_id)
        {
            $message = $newsfeedLike->user->name.' has Liked your Post';
            $user = User::select('id', 'name', 'staff_type')->find($newsfeedLike->newsfeed->user_id);
            $link = $this->staffUrl($user, $newsfeedLike->newsfeed_id);
            Notification::send($user, new NewsfeedNotification($newsfeedLike, $message, $link));
        }
    }

    /**
     * Handle the NewsfeedLike "updated" event.
     *
     * @param  \App\Models\NewsfeedLike  $newsfeedLike
     * @return void
     */
    public function updated(NewsfeedLike $newsfeedLike)
    {
        //
    }

    /**
     * Handle the NewsfeedLike "deleted" event.
     *
     * @param  \App\Models\NewsfeedLike  $newsfeedLike
     * @return void
     */
    public function deleted(NewsfeedLike $newsfeedLike)
    {
        //
    }

    /**
     * Handle the NewsfeedLike "restored" event.
     *
     * @param  \App\Models\NewsfeedLike  $newsfeedLike
     * @return void
     */
    public function restored(NewsfeedLike $newsfeedLike)
    {
        //
    }

    /**
     * Handle the NewsfeedLike "force deleted" event.
     *
     * @param  \App\Models\NewsfeedLike  $newsfeedLike
     * @return void
     */
    public function forceDeleted(NewsfeedLike $newsfeedLike)
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
