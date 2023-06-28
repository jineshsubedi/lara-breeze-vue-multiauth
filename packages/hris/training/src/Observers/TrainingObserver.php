<?php

namespace Hris\Training\Observers;

use App\Models\User;
use Hris\Training\Models\Training;
use Hris\Training\Models\TrainingNotice;
use Hris\Training\Notifications\TrainingNoticeNotification;
use Illuminate\Support\Facades\Notification;

class TrainingObserver
{
    /**
     * Handle the Training "created" event.
     *
     * @param  \App\Models\Training  $training
     * @return void
     */
    public function created(Training $training)
    {
        if($training->isDirty('status') && $training->status == 1)
        {
            $training->load(['notice', 'program']);
            $this->trainingNoticeNotification($training);
        }
    }

    /**
     * Handle the Training "updated" event.
     *
     * @param  \App\Models\Training  $training
     * @return void
     */
    public function updated(Training $training)
    {
        if($training->isDirty('status') && $training->status == 1)
        {
            $training->load(['notice', 'program']);
            $this->trainingNoticeNotification($training);
        }
    }

    /**
     * Handle the Training "deleted" event.
     *
     * @param  \App\Models\Training  $training
     * @return void
     */
    public function deleted(Training $training)
    {
        //
    }

    /**
     * Handle the Training "restored" event.
     *
     * @param  \App\Models\Training  $training
     * @return void
     */
    public function restored(Training $training)
    {
        //
    }

    /**
     * Handle the Training "force deleted" event.
     *
     * @param  \App\Models\Training  $training
     * @return void
     */
    public function forceDeleted(Training $training)
    {
        //
    }

    private function trainingNoticeNotification($training)
    {
        $users = User::where('branch_id', $training->branch_id)->active()->get(['id', 'name', 'staff_type']);
        $message = request()->description;
        foreach($users as $user)
        {
            $link = $this->staffUrl($user, $training->id);
            Notification::send($user, new TrainingNoticeNotification($training, $message, $link));
        }
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.mytrainings.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.mytrainings.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.mytrainings.show', $id);
        }
    }
}
