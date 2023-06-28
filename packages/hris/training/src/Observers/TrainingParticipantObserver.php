<?php

namespace Hris\Training\Observers;

use App\Models\BranchSetting;
use App\Models\User;
use Hris\Training\Models\Training;
use Hris\Training\Models\TrainingParticipant;
use Hris\Training\Notifications\TrainingNoticeNotification;
use Illuminate\Support\Facades\Notification;

class TrainingParticipantObserver
{
    /**
     * Handle the TrainingParticipant "created" event.
     *
     * @param  \App\Models\TrainingParticipant  $trainingParticipant
     * @return void
     */
    public function created(TrainingParticipant $trainingParticipant)
    {
        $training = Training::with(['program:id,title'])->findOrFail($trainingParticipant->training_id);
        $branchSetting = BranchSetting::where('branch_id', $training->branch_id)->select('id', 'training_handler')->first();
        if(isset($branchSetting->training_handler) && $branchSetting->training_handler !== 0)
        {
            $user = User::select('id', 'name', 'staff_type')->find($branchSetting->training_handler);
            $participant = User::select('id', 'name', 'staff_type')->find($trainingParticipant->user_id);
            $message = $participant->name. ' has requested to take participate in '.$training->program->title;
            $link = $this->staffUrl($user, $training->id);
            Notification::send($user, new TrainingNoticeNotification($training, $message, $link));
        }
    }

    /**
     * Handle the TrainingParticipant "updated" event.
     *
     * @param  \App\Models\TrainingParticipant  $trainingParticipant
     * @return void
     */
    public function updated(TrainingParticipant $trainingParticipant)
    {
        $training = Training::with(['program:id,title'])->findOrFail($trainingParticipant->training_id);
        $participant = User::select('id', 'name', 'staff_type')->find($trainingParticipant->user_id);
        $ttype = $trainingParticipant->status == 1 ? 'Accepted' : 'Rejected';
        $message = 'Your request for participation in '.$training->program->title.' is '.$ttype;
        $link = $this->staffUrl2($participant, $training->id);
        Notification::send($participant, new TrainingNoticeNotification($training, $message, $link));
    }

    /**
     * Handle the TrainingParticipant "deleted" event.
     *
     * @param  \App\Models\TrainingParticipant  $trainingParticipant
     * @return void
     */
    public function deleted(TrainingParticipant $trainingParticipant)
    {
        //
    }

    /**
     * Handle the TrainingParticipant "restored" event.
     *
     * @param  \App\Models\TrainingParticipant  $trainingParticipant
     * @return void
     */
    public function restored(TrainingParticipant $trainingParticipant)
    {
        //
    }

    /**
     * Handle the TrainingParticipant "force deleted" event.
     *
     * @param  \App\Models\TrainingParticipant  $trainingParticipant
     * @return void
     */
    public function forceDeleted(TrainingParticipant $trainingParticipant)
    {
        //
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.trainings.participants', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.trainings.participants', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.trainings.participants', $id);
        }
    }
    private function staffUrl2($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.trainings.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.trainings.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.trainings.show', $id);
        }
    }
}
