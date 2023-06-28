<?php

namespace Hris\Offboarding\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Offboarding\Enums\ResignationStatus;
use Hris\Offboarding\Models\ResignationStaff;
use Hris\Offboarding\Notifications\ResignationStaffNotification;
use Illuminate\Support\Facades\Notification;

class ResignationStaffObserver
{
    public function creating(ResignationStaff $resignationStaff)
    {
        $resignationStaff->branch_id = auth()->user()->branch_id;
        $resignationStaff->supervisor = auth()->user()->supervisor_id;
        $resignationStaff->resignation_date = Date('Y-m-d');
    }
    /**
     * Handle the ResignationStaff "created" event.
     *
     * @param  \App\Models\ResignationStaff  $resignationStaff
     * @return void
     */
    public function created(ResignationStaff $resignationStaff)
    {
        $resignationStaff->load(['user:id,name', 'type:id,title', 'reason:id,title', 'retraction']);
        $user = User::active()->branchId()->role('HrHandler')->first();
        $message = $resignationStaff->user->name.' Has created a Resignation Request';
        $link = $this->staffUrl($user, $resignationStaff->id);
        Notification::send($user, new ResignationStaffNotification($resignationStaff, $message, $link));

    }

    /**
     * Handle the ResignationStaff "updated" event.
     *
     * @param  \App\Models\ResignationStaff  $resignationStaff
     * @return void
     */
    public function updated(ResignationStaff $resignationStaff)
    {
        if($resignationStaff->isDirty('status'))
        {
            $user = User::find($resignationStaff->user_id);
            if($resignationStaff->status == ResignationStatus::APPROVED->value)
            {
                $message = 'Resignation Request has been Approved';
            }
            if($resignationStaff->status == ResignationStatus::REJECTED->value)
            {
                $message = 'Resignation Request has been Rejected';
            } 
            $link = $this->normalStaffUrl($user, $resignationStaff->id);
            Notification::send($user, new ResignationStaffNotification($resignationStaff, $message, $link));
        }
    }

    /**
     * Handle the ResignationStaff "deleted" event.
     *
     * @param  \App\Models\ResignationStaff  $resignationStaff
     * @return void
     */
    public function deleted(ResignationStaff $resignationStaff)
    {
        //
    }

    /**
     * Handle the ResignationStaff "restored" event.
     *
     * @param  \App\Models\ResignationStaff  $resignationStaff
     * @return void
     */
    public function restored(ResignationStaff $resignationStaff)
    {
        //
    }

    /**
     * Handle the ResignationStaff "force deleted" event.
     *
     * @param  \App\Models\ResignationStaff  $resignationStaff
     * @return void
     */
    public function forceDeleted(ResignationStaff $resignationStaff)
    {
        //
    }
    private function normalStaffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.resignations.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.resignations.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.resignations.show', $id);
        }
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.resignationstaffs.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.resignationstaffs.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.resignationstaffs.show', $id);
        }
    }
}
