<?php

namespace App\Observers;

use App\Models\CompensatoryOff;
use App\Models\Leave;
use App\Models\LeaveHandover;
use App\Models\LeaveSetting;
use App\Models\User;
use App\Notifications\LeaveRequestNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class LeaveObserver
{
    protected $disk = 'public';
    protected $path = 'leave_documents';

    public function creating(Leave $leave)
    {
        $doc = '';
        if (request()->hasFile('documentFile')) {
            $doc = request()->file('documentFile')->store($this->path, $this->disk);
        }
        $leave->document = $doc;
        $leave->user_id = auth()->id();
        $leave->branch_id = auth()->user()->branch_id;
        if(request()->accrual == 0)
        {
            $leave->paid = '1';
        }
        if(request()->remaining == 0 || request()->join_duration < request()->eligible)
        {
            $leave->paid = '1';
        }
    }
    /**
     * Handle the Leave "created" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function created(Leave $leave)
    {
        $leave->load(['leaveType:id,title']);
        $user = User::find(auth()->id());
        $message = auth()->user()->name.' Your Leave Request is Submitted Successfully!';
        $link = $this->staffUrl($user, $leave->id);
        Notification::send($user, new LeaveRequestNotification($leave, $message, $link));

        if($user->supervisor_id != '')
        {
            $supervisor = User::find($user->supervisor_id);
            $message = auth()->user()->name.' Has Requested a Leave Request';
            $link = $this->staffUrl($supervisor, $leave->id);
            Notification::send($supervisor, new LeaveRequestNotification($leave, $message, $link));
        }
    }

    /**
     * Handle the Leave "updated" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function updated(Leave $leave)
    {
        $this->approvalUpdate($leave);
    }

    private function approvalUpdate($leave)
    {
        if($leave->isDirty('s_approve')){
            if($leave->s_approve == '1')
                $message = 'Supervisor Approved your Leave Request';
            else 
                $message = 'Supervisor Rejected your Leave Request';
        }
        if($leave->isDirty('h_approve')){
            if($leave->h_approve == '1')
                $message = 'HR Approved your Leave Request';
            else 
                $message = 'HR Rejected your Leave Request';
        }
        if($leave->isDirty('m_approve')){
            if($leave->m_approve == '1')
                $message = 'Manager Approved your Leave Request';
            else 
                $message = 'Manager Rejected your Leave Request';
        }
        $user = User::find($leave->user_id);
        $link = $this->staffUrl($user, $leave->id);
        Notification::send($user, new LeaveRequestNotification($leave, $message, $link));
    }

    /**
     * Handle the Leave "deleted" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function deleted(Leave $leave)
    {
        if(Storage::exists($leave->document))
        {
            Storage::delete($leave->document);
        }
    }

    /**
     * Handle the Leave "restored" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function restored(Leave $leave)
    {
        //
    }

    /**
     * Handle the Leave "force deleted" event.
     *
     * @param  \App\Models\Leave  $leave
     * @return void
     */
    public function forceDeleted(Leave $leave)
    {
        //
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.leaves.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.leaves.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.leaves.show', $id);
        }
    }
}
