<?php

namespace Hris\Survey\Observers;

use App\Models\User;
use Hris\Survey\Models\Survey;
use Hris\Survey\Models\SurveyAnswer;
use Hris\Survey\Notifications\SurveyNotification;
use Illuminate\Support\Facades\Notification;

class SurveyObserver
{
    public function creating(Survey $survey)
    {
        $survey->branch_id = auth()->user()->branch_id;
    }
    public function created(Survey $survey)
    {
        $this->fetchSurveyNotification($survey);
    }
    public function updated(Survey $survey)
    {
        $this->fetchSurveyNotification($survey);
    }
    protected function fetchSurveyNotification($survey)
    {
        if($survey->status == 1 && $survey->isDirty('status'))
        {
            $users = User::active()->where('branch_id', $survey->branch_id)->get(['id', 'name', 'staff_type']);
            foreach($users as $user)
            {
                $check = SurveyAnswer::where('survey_id', $survey->id)->where('user_id', $user->id)->count();
                if($check < 1)
                {
                    $link = $this->staffUrl($user, $survey->id);
                    $message = strip_tags($survey->description);
                    Notification::send($user, new SurveyNotification($survey, $message, $link));
                }
            }
        }
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.mysurveys.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.mysurveys.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.mysurveys.show', $id);
        }
    }
}
