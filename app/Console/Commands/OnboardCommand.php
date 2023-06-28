<?php

namespace App\Console\Commands;

use App\Enums\StaffType;
use App\Models\User;
use App\Models\UserDocument;
use Hris\Onboarding\Enums\OnboardStatus;
use Hris\Onboarding\Models\OnBoardStaff;
use Hris\Onboarding\Notifications\OnBoardStaffNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class OnboardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onboard:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User and send Notification to Admin User';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $staffs = OnBoardStaff::where('supervisor_approval', OnboardStatus::ACCEPT->value)
        ->where('hr_approval', OnboardStatus::ACCEPT->value)
        ->get();
        foreach($staffs as $staff)
        {
            $user = User::create([
                'branch_id' => $staff->branch_id,
                'name' => $staff->name,
                'email' => $staff->email,
                'staff_type' => $staff->staff_type,
                'department_id' => $staff->department_id,
                'designation_id' => $staff->designation_id,
                'supervisor_id' => $staff->supervisor_id,
                'password'=> bcrypt('password'),
                'status' => User::CURRENTLY_WORKING,
                'employment_type' => $staff->nature_of_job,
                'join_date' => $staff->joining_date,
            ]);
            $cv =  $staff->getRawOriginal('cv');
            if($cv != '')
            {
                UserDocument::create([
                    'user_id' => $user->id,
                    'title' => 'cv',
                    'document' => $cv
                ]);
            }
            $hr = User::active()->where('branch_id', $staff->branch_id)->role('HrHandler')->first();
            $link = $this->staffUrl($hr, $staff->id);
            $message = $staff->name.' has Onboard Successfully! Please Update the Necessary Attributes';
            Notification::send($hr, new OnBoardStaffNotification($staff, $message, $link));
        }
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.users.edit', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.users.edit', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.users.edit', $id);
        }
    }
}
