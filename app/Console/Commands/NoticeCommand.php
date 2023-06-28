<?php

namespace App\Console\Commands;

use App\Enums\StaffType;
use App\Models\Notice;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NoticeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notice:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will Send the Notice Notification';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notices = Notice::where('start_date', Carbon::today()->format('Y-m-d'))
                ->orWhere('end_date', '<=', Carbon::today()->format('Y-m-d'))
                ->get();
        foreach($notices as $notice)
        {
            $users = User::active()->where('branch_id', $notice->branch_id)->get(['id', 'name', 'staff_type']);
            foreach($users as $user)
            {
                $link = $this->staffUrl($user, $notice->id);
                $message = strip_tags($notice->description);
                Notification::send($user, new NoticeNotification($notice, $message, $link));
            }
        }

        return Command::SUCCESS;
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.notices.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.notices.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.notices.show', $id);
        }
    }
}
