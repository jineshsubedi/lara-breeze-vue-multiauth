<?php

namespace Hris\Overtime\Observers;

use App\Models\BranchSetting;
use App\Models\User;
use Hris\Overtime\Models\Overtime;
use Hris\Overtime\Notifications\OvertimeNotification;
use Illuminate\Support\Facades\Notification;

class OvertimeObserver
{
    public function creating(Overtime $overtime)
    {
        $overtime->branch_id = auth()->user()->branch_id;
        $overtime->user_id = auth()->id();
    }
    public function created(Overtime $overtime)
    {
        $branch = BranchSetting::where('branch_id', $overtime->branch_id)->first();
        $ids = [$branch->hr_handler, auth()->user()->supervisor_id];
        $users = User::whereIn('id', $ids)->get(['id', 'name', 'staff_type']);
        foreach($users as $user)
        {
            $link = $this->staffUrl($user, $overtime->id);
            $message = auth()->user()->name.' has requested Overtime Request';
            Notification::send($user, new OvertimeNotification($overtime, $message, $link));
        }
    }
    public function updated(Overtime $overtime)
    {
        if($overtime->isDirty('status'))
        {
            $user = User::find($overtime->user_id);
            $link = $this->staffUrl($user, $overtime->id);
            if($overtime->status == '1')
            {
                $message = 'You Overtime Request is Approved By Supervisor';
            }
            if($overtime->status == '2')
            {
                $message = 'You Overtime Request is Approved By HR';
            }
            if($overtime->status == '3')
            {
                $message = 'You Overtime Request is Rejected';
            }
            Notification::send($user, new OvertimeNotification($overtime, $message, $link));
        }
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.overtimes.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.overtimes.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.overtimes.show', $id);
        }
    }
}
