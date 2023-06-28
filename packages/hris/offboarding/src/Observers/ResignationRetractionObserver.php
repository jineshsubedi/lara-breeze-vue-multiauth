<?php

namespace Hris\Offboarding\Observers;

use App\Enums\StaffType;
use App\Models\User;
use Hris\Offboarding\Enums\ResignationStatus;
use Hris\Offboarding\Models\ResignationRetraction;
use Illuminate\Support\Facades\Notification;
use Hris\Offboarding\Notifications\ResignationStaffNotification;

class ResignationRetractionObserver
{
    public function creating(ResignationRetraction $resignationRetraction)
    {
        $resignationRetraction->branch_id = auth()->user()->branch_id;
        $resignationRetraction->user_id = auth()->id();
    }
    /**
     * Handle the ResignationRetraction "created" event.
     *
     * @param  \App\Models\ResignationRetraction  $resignationRetraction
     * @return void
     */
    public function created(ResignationRetraction $resignationRetraction)
    {
        $resignationRetraction->load(['user:id,name']);
        $user = User::active()->branchId()->role('HrHandler')->first();
        $message = $resignationRetraction->user->name.' Has created a Resignation Retraction Request';
        $link = $this->staffUrl($user, $resignationRetraction->resignation_staffs_id);
        Notification::send($user, new ResignationStaffNotification($resignationRetraction, $message, $link));
    }

    /**
     * Handle the ResignationRetraction "updated" event.
     *
     * @param  \App\Models\ResignationRetraction  $resignationRetraction
     * @return void
     */
    public function updated(ResignationRetraction $resignationRetraction)
    {
        if($resignationRetraction->isDirty('hr_approval'))
        {
            $user = User::find($resignationRetraction->user_id);
            if($resignationRetraction->hr_approval == ResignationStatus::APPROVED->value)
                $message = 'Resignation Request has been Approved';
            else
                $message = 'Resignation Request has been Rejected';
            $link = $this->normalStaffUrl($user, $resignationRetraction->resignation_staffs_id);
            Notification::send($user, new ResignationStaffNotification($resignationRetraction, $message, $link));
        }
    }

    /**
     * Handle the ResignationRetraction "deleted" event.
     *
     * @param  \App\Models\ResignationRetraction  $resignationRetraction
     * @return void
     */
    public function deleted(ResignationRetraction $resignationRetraction)
    {
        //
    }

    /**
     * Handle the ResignationRetraction "restored" event.
     *
     * @param  \App\Models\ResignationRetraction  $resignationRetraction
     * @return void
     */
    public function restored(ResignationRetraction $resignationRetraction)
    {
        //
    }

    /**
     * Handle the ResignationRetraction "force deleted" event.
     *
     * @param  \App\Models\ResignationRetraction  $resignationRetraction
     * @return void
     */
    public function forceDeleted(ResignationRetraction $resignationRetraction)
    {
        //
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
}
