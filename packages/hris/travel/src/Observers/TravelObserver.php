<?php

namespace Hris\Travel\Observers;

use App\Enums\StaffType;
use App\Models\LeaveSetting;
use App\Models\User;
use Exception;
use Hris\Travel\Models\Travel;
use Hris\Travel\Notifications\TravelNotification;
use Illuminate\Support\Facades\Notification;

class TravelObserver
{
    public function creating(Travel $travel)
    {
        $travel->assigned_from = auth()->id();
        $travel->branch_id = auth()->user()->branch_id;
        $travel->unique_id = 'T'.Date('y').Date('m').Date('d').rand(1,100);
    }
    /**
     * Handle the Travel "created" event.
     *
     * @param  \App\Models\Travel  $travel
     * @return void
     */
    public function created(Travel $travel)
    {
        $travel->load(['assign_from:id,name', 'assign_to:id,name']);
        $user = User::find($travel->assigned_to);
        $message = $travel->assign_from->name.' Has made a Travel Request for you.';
        $link = $this->staffUrl($user, $travel->id);
        Notification::send($user, new TravelNotification($travel, $message, $link));

        $supervisor = User::find($user->supervisor_id);
        $message = $user->name.' Has A Travel Request.';
        $link = $this->staffUrl($supervisor, $travel->id);
        Notification::send($user, new TravelNotification($travel, $message, $link));
    }

    /**
     * Handle the Travel "updated" event.
     *
     * @param  \App\Models\Travel  $travel
     * @return void
     */
    public function updated(Travel $travel)
    {
        $user = User::find($travel->assigned_to);
        if($travel->isDirty('supervisor_approval') && $travel->supervisor_approval == 1){
            $account = User::active()->branchId()->role('PayrollHandler')->first();
            $message = $user->name.', Travel Request is waiting for the approval';
            $link = $this->staffUrl($account, $travel->id);
            Notification::send($account, new TravelNotification($travel, $message, $link));
        }
        if($travel->isDirty('account_approval') && $travel->account_approval == 1){
            $hr = User::active()->branchId()->role('HrHandler')->first();
            $message = $user->name.', Travel Request is waiting for the approval';
            $link = $this->staffUrl($hr, $travel->id);
            Notification::send($hr, new TravelNotification($travel, $message, $link));
        }
        if($travel->isDirty('hr_approval') && $travel->hr_approval == 1){
            try{
                $setting = LeaveSetting::where('branch_id', auth()->user()->branch_id)->first();
                if(isset($setting->id) && $setting->m_person != '')
                {
                    $chairman = User::find($setting->m_person);
                    $message = $user->name.', Travel Request is waiting for the approval';
                    $link = $this->staffUrl($chairman, $travel->id);
                    Notification::send($chairman, new TravelNotification($travel, $message, $link));
                }
            }catch(Exception $e)
            {

            }
        }
        $message = 'Dear '.$user->name.', Your Travel Request has Approval Updates';
        $link = $this->staffUrl($user, $travel->id);
        Notification::send($user, new TravelNotification($travel, $message, $link));
    }

    /**
     * Handle the Travel "deleted" event.
     *
     * @param  \App\Models\Travel  $travel
     * @return void
     */
    public function deleted(Travel $travel)
    {
        //
    }

    /**
     * Handle the Travel "restored" event.
     *
     * @param  \App\Models\Travel  $travel
     * @return void
     */
    public function restored(Travel $travel)
    {
        //
    }

    /**
     * Handle the Travel "force deleted" event.
     *
     * @param  \App\Models\Travel  $travel
     * @return void
     */
    public function forceDeleted(Travel $travel)
    {
        //
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.travels.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.travels.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.travels.show', $id);
        }
    }
}
