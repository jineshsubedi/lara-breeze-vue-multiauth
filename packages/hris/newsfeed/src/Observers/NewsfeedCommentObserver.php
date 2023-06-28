<?php

namespace Hris\Newsfeed\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Newsfeed\Models\NewsfeedComment;
use Hris\Newsfeed\Notifications\NewsfeedNotification;
use Illuminate\Support\Facades\Notification;

class NewsfeedCommentObserver
{
    /**
     * Handle the NewsfeedComment "created" event.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return void
     */
    public function created(NewsfeedComment $newsfeedComment)
    {
        $newsfeedComment->load(['user:id,name', 'newsfeed:id,user_id']);
        if($newsfeedComment->user_id != $newsfeedComment->newsfeed->user_id)
        {
            $message = $newsfeedComment->user->name.' has Commented on your Post';
            $user = User::select('id', 'name', 'staff_type')->find($newsfeedComment->newsfeed->user_id);
            $link = $this->staffUrl($user, $newsfeedComment->newsfeed_id);
            Notification::send($user, new NewsfeedNotification($newsfeedComment, $message, $link));
        }
    }

    /**
     * Handle the NewsfeedComment "updated" event.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return void
     */
    public function updated(NewsfeedComment $newsfeedComment)
    {
        //
    }

    /**
     * Handle the NewsfeedComment "deleted" event.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return void
     */
    public function deleted(NewsfeedComment $newsfeedComment)
    {
        //
    }

    /**
     * Handle the NewsfeedComment "restored" event.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return void
     */
    public function restored(NewsfeedComment $newsfeedComment)
    {
        //
    }

    /**
     * Handle the NewsfeedComment "force deleted" event.
     *
     * @param  \App\Models\NewsfeedComment  $newsfeedComment
     * @return void
     */
    public function forceDeleted(NewsfeedComment $newsfeedComment)
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
