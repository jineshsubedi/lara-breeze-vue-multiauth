<?php

namespace Hris\Task\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Task\Models\HelpDesk;
use Illuminate\Support\Facades\Notification;
use Hris\Task\Notifications\HelpDeskNotification;

class HelpDeskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param  \Hris\Task\Models\HelpDesk  $helpDesk
     * @return void
     */
    public function created(HelpDesk $helpdesk)
    {
        $helpdesk->load(['fromUser:id,name', 'toUser:id,name']);
        $user = User::find($helpdesk->task_to);
        $message = $helpdesk->fromUser->name.' Has Requested a Help Desk for you.';
        $link = $this->staffUrl($user, $helpdesk->id);
        Notification::send($user, new HelpDeskNotification($helpdesk, $message, $link));
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \Hris\Task\Models\HelpDesk  $helpdesk
     * @return void
     */
    public function updated(HelpDesk $helpdesk)
    {
        $helpdesk->load(['fromUser:id,name', 'toUser:id,name']);
        if($helpdesk->isDirty('accept_status')){
            $user = User::find($helpdesk->task_from);
            $message = $helpdesk->toUser->name.' Has Accepted Your Help Desk';
            $link = $this->staffUrl($user, $helpdesk->id);
            Notification::send($user, new HelpDeskNotification($helpdesk, $message, $link));
        }
        if($helpdesk->isDirty('complete_status')){
            $user = User::find($helpdesk->task_from);
            $message = $helpdesk->toUser->name.' Has Completed Your Help Desk';
            $link = $this->staffUrl($user, $helpdesk->id);
            Notification::send($user, new HelpDeskNotification($helpdesk, $message, $link));
        }
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param  \Hris\Task\Models\HelpDesk  $helpdesk
     * @return void
     */
    public function deleted(HelpDesk $helpdesk)
    {
        $helpdesk->load(['fromUser:id,name', 'toUser:id,name']);
        $user = User::find($helpdesk->task_to);
        $message = $helpdesk->fromUser->name.' Has Deleted a Help Desk Assigned to You]';
        $link = '';
        Notification::send($user, new HelpDeskNotification($helpdesk, $message, $link));
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \Hris\Task\Models\HelpDesk  $helpDesk
     * @return void
     */
    public function restored(HelpDesk $helpDesk)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \Hris\Task\Models\HelpDesk  $task
     * @return void
     */
    public function forceDeleted(HelpDesk $helpDesk)
    {
        //
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.helpdesks.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.helpdesks.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.helpdesks.show', $id);
        }
    }
}
