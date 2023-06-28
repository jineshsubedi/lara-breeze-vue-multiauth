<?php

namespace App\Console\Commands;

use App\Enums\StaffType;
use App\Models\User;
use Carbon\Carbon;
use Hris\Event\Models\Event;
use Hris\Event\Notifications\EventNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class EventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will dispatch events';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = Event::whereDate('start_date', Carbon::today()->format('Y-m-d'))
                ->orWhereDate('end_date', '<=', Carbon::today()->format('Y-m-d'))
                ->get();
        foreach($events as $event)
        {
            $users = User::active()->whereIn('branch_id', $event->branch)->get(['id', 'name', 'staff_type']);
            foreach($users as $user)
            {
                $link = $this->staffUrl($user, $event->id);
                $message = strip_tags($event->description);
                Notification::send($user, new EventNotification($event, $message, $link));
            }
        }
        return Command::SUCCESS;
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.events.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.events.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.events.show', $id);
        }
    }
}
