<?php

namespace App\Console\Commands;

use App\Enums\StaffType;
use App\Models\User;
use Carbon\Carbon;
use Hris\Survey\Models\Survey;
use Hris\Survey\Models\SurveyAnswer;
use Hris\Survey\Notifications\SurveyNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SurveyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will Send the Survey Notification';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $surveys = Survey::where('start_date', Carbon::today()->format('Y-m-d'))
                ->orWhere('end_date', Carbon::today()->format('Y-m-d'))
                ->get();
            foreach($surveys as $survey)
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
        } catch (\Throwable $th) {
            //throw $th;
        }

        return Command::SUCCESS;
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.mysurveys.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.mysurveys.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.mysurveys.show', $id);
        }
    }
}
