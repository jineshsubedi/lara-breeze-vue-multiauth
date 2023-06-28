<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Branch;
use App\Enums\StaffType;
use Illuminate\Console\Command;
use Hris\Newsfeed\Models\Newsfeed;
use Hris\Newsfeed\Enums\NewsfeedEvent;
use Illuminate\Support\Facades\Notification;
use Hris\Newsfeed\Notifications\NewsfeedNotification;

class NewsfeedAnniversaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsfeedAnniversary:dispatch';

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
        $branches = Branch::with(['users' => function($q){
            return $q->where('join_date', '!=', null)
                    ->whereDay('join_date', Date('d'))
                    ->whereMonth('join_date', Date('m'));
        }])->get();
        $title = 'HAPPY ANNIVERSARY';
        $background = asset("images/newsfeed/anniversary.jpg");
        foreach($branches as $branch)
        {
            $hr = User::active()->where('branch_id', $branch->id)->role('HrHandler')->first();
            foreach($branch->users as $user)
            {
                $html = '<div style="width:100%; background-image: url('.$background.'); background-repeat: no-repeat; background-size: cover;margin-top:5px;">
                <div class="text-center" style="padding-top: 50px;padding-bottom: 50px;">
                    <h3>'.$title.'</h3>
                    <div style="display:flex; justify-content: center; align-items: center;">
                    <img alt="profile picture" class="img-circle" src="'.$user->avatar_path.'" style="width: 100px; height: 100px; object-fit:contain; border: 1px solid #9f9fd2;"></div>
                    <div>
                        <span style="font-size: 30px; font-family: cursive; padding: 5px;">'.$user->name.'</span>
                        <br>
                        <span style="font-size: 20px; font-family: cursive; text-align: center; padding: 5px; line-height: 1.9;">On behalf of the entire team, I\'d like to congratulate you on reaching another milestone in your career with us. We are so grateful for the hard work and dedication you have put in over the years, and we truly appreciate your contributions to our team.</span>
                    </div>
                </div>
                </div>';
                $feed = new Newsfeed();
                $feed->user_id = $hr->id;
                $feed->branch_id = $branch->id;
                $feed->to_staff = $user->id;
                $feed->event = $html;
                $feed->event_category = NewsfeedEvent::ANNIVERSARY->value;
                $feed->saveQuietly();


                $message = $hr->name.' Has Created your '.$title.' Post';
                $link = $this->staffUrl($user, $feed->id);
                Notification::send($user, new NewsfeedNotification($feed, $message, $link));
            }
        }
        return Command::SUCCESS;
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.newsfeeds.show', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.newsfeeds.show', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.newsfeeds.show', $id);
        }
    }
}
