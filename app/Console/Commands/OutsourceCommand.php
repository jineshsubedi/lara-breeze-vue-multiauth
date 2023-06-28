<?php

namespace App\Console\Commands;

use App\Enums\StaffType;
use App\Models\User;
use Carbon\Carbon;
use Hris\Outsource\Enums\OutSourceStatus;
use Hris\Outsource\Models\Outsource;
use Hris\Outsource\Notifications\OutsourceNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class OutsourceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outsource:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch Outsource Notification';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
            $outsources = Outsource::where('status', OutSourceStatus::ACTIVE->value)
                ->whereDate('contract_end', $endOfMonth)
                ->orWhereDate('contract_end', $endOfWeek)
                ->get();
            
            foreach($outsources as $outsource)
            {
                $users = User::active()->where('branch_id', $outsource->branch_id)->whereIn('id', [$outsource->manager, $outsource->supervisor])->get();
                foreach($users as $user)
                {
                    $link = $this->staffUrl($user, $outsource->id);
                    $message = 'Project will expire on '.$outsource->contract_end.'.';
                    Notification::send($user, new OutsourceNotification($outsource, $message, $link));
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.outsources.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.outsources.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.outsources.show', $id);
        }
    }
}
