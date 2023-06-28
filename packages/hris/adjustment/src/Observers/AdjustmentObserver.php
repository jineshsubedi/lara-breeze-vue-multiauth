<?php

namespace Hris\Adjustment\Observers;

use App\Models\BranchSetting;
use App\Models\User;
use Hris\Adjustment\Models\Adjustment;
use Hris\Adjustment\Notifications\AdjustmentNotification;
use Illuminate\Support\Facades\Notification;

class AdjustmentObserver
{
    public function creating(Adjustment $adjustment)
    {
        $adjustment->branch_id = auth()->user()->branch_id;
        $adjustment->user_id = auth()->id();
    }
    public function created(Adjustment $adjustment)
    {
        $branch = BranchSetting::where('branch_id', $adjustment->branch_id)->first();
        $ids = [$branch->hr_handler, auth()->user()->supervisor_id];
        $users = User::whereIn('id', $ids)->get(['id', 'name', 'staff_type']);
        foreach($users as $user)
        {
            $link = $this->staffUrl($user, $adjustment->id);
            $message = auth()->user()->name.' has requested Adjustment Request';
            Notification::send($user, new AdjustmentNotification($adjustment, $message, $link));
        }
    }
    public function updated(Adjustment $adjustment)
    {
        if($adjustment->isDirty('status'))
        {
            $user = User::find($adjustment->user_id);
            $link = $this->staffUrl($user, $adjustment->id);
            if($adjustment->status == '1')
            {
                $message = 'You Adjustment Request is Approved By Supervisor';
            }
            if($adjustment->status == '2')
            {
                $message = 'You Adjustment Request is Approved By HR';
            }
            if($adjustment->status == '3')
            {
                $message = 'You Adjustment Request is Rejected';
            }
            Notification::send($user, new AdjustmentNotification($adjustment, $message, $link));
        }
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.adjustments.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.adjustments.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.adjustments.show', $id);
        }
    }
}
