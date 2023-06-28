<?php

namespace App\Console\Commands;

use App\Models\User;
use Hris\Training\Models\Training;
use Hris\Training\Notifications\TrainingNoticeNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TrainingNoticeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'training:notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $notices = Training::with(['program', 'branch'])->leftjoin('training_notices', 'trainings.id', 'training_notices.training_id')
                ->where('trainings.status', 1)
                ->where('training_notices.notice_date', '<=', Date('Y-m-d'))
                ->where('training_notices.submit_date', '>=', Date('Y-m-d'))
                ->select('trainings.*', 'training_notices.notice_date as notice_date', 'training_notices.submit_date as submit_date')
                ->get();
            
            foreach($notices as $training)
            {
                $users = User::active()->where('branch_id', $training->branch_id)->get(['id', 'name', 'staff_type']);
                $message = $training->notice->description;
                foreach($users as $user)
                {
                    $link = $this->staffUrl($user, $training->id);
                    Notification::send($user, new TrainingNoticeNotification($training, $message, $link));
                }
            }
            return Command::SUCCESS;
        } catch (\Throwable $th) {
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
