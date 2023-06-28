<?php

namespace Hris\Onboarding\Observers;

use Carbon\Carbon;
use Hris\Onboarding\Enums\OnboardStatus;
use Hris\Onboarding\Models\OnBoardStaff;

class OnBoardStaffObserver
{
    public function creating(OnBoardStaff $onBoardStaff)
    {
        $onBoardStaff->branch_id = auth()->user()->branch_id;
        if($onBoardStaff->trail_period == 1)
        {
            $onBoardStaff->joining_date = Carbon::parse($onBoardStaff->trail_start_date)->addDays($onBoardStaff->no_of_days)->format('Y-m-d');
            $onBoardStaff->supervisor_approval = OnboardStatus::PENDING->value;
            $onBoardStaff->hr_approval = OnboardStatus::PENDING->value;
        }else{
            $onBoardStaff->supervisor_approval = OnboardStatus::ACCEPT->value;
            $onBoardStaff->supervisor_comment = 'AUTO';
            $onBoardStaff->supervisor_approval_date = Date('Y-m-d');
            $onBoardStaff->hr_approval = OnboardStatus::ACCEPT->value; 
            $onBoardStaff->hr_comment = 'AUTO';
            $onBoardStaff->hr_approval_date = Date('Y-m-d');
        }
    }
    /**
     * Handle the OnBoardStaff "created" event.
     *
     * @param  \App\Models\OnBoardStaff  $onBoardStaff
     * @return void
     */
    public function created(OnBoardStaff $onBoardStaff)
    {
        //
    }

    /**
     * Handle the OnBoardStaff "updated" event.
     *
     * @param  \App\Models\OnBoardStaff  $onBoardStaff
     * @return void
     */
    public function updated(OnBoardStaff $onBoardStaff)
    {
        //
    }

    /**
     * Handle the OnBoardStaff "deleted" event.
     *
     * @param  \App\Models\OnBoardStaff  $onBoardStaff
     * @return void
     */
    public function deleted(OnBoardStaff $onBoardStaff)
    {
        //
    }

    /**
     * Handle the OnBoardStaff "restored" event.
     *
     * @param  \App\Models\OnBoardStaff  $onBoardStaff
     * @return void
     */
    public function restored(OnBoardStaff $onBoardStaff)
    {
        //
    }

    /**
     * Handle the OnBoardStaff "force deleted" event.
     *
     * @param  \App\Models\OnBoardStaff  $onBoardStaff
     * @return void
     */
    public function forceDeleted(OnBoardStaff $onBoardStaff)
    {
        //
    }
}
