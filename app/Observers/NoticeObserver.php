<?php

namespace App\Observers;

use App\Models\Notice;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Illuminate\Support\Facades\Notification;

class NoticeObserver
{
    public function creating(Notice $notice)
    {
        $notice->branch_id = auth()->user()->branch_id;
    }
    public function created(Notice $notice)
    {
        // $this->noticeNotification($notice);
    }
    public function updated(Notice $notice)
    {
        // $this->noticeNotification($notice);
    }

    public function noticeNotification($notice)
    {
        $users = User::active()->where('branch_id', $notice->branch_id)->get(['id', 'name', 'staff_type']);
        foreach($users as $user)
        {
            $link = $this->staffUrl($user, $notice->id);
            $message = strip_tags($notice->description);
            Notification::send($user, new NoticeNotification($notice, $message, $link));
        }
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.notices.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.notices.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.notices.show', $id);
        }
    }
}
