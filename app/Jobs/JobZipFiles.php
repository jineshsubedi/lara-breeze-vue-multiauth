<?php

namespace App\Jobs;

use App\Enums\StaffType;
use App\Models\Jobs;
use App\Models\User;
use App\Notifications\Jobs\ZipFileNotification;
use ZipArchive;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class JobZipFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $folderPath;
    protected $zipFileName;
    protected $user_id;
    protected $job_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $folderPath, string $zipFileName, int $user_id, int $job_id)
    {
        $this->folderPath = $folderPath;
        $this->zipFileName = $zipFileName;
        $this->user_id = $user_id;
        $this->job_id = $job_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $zip = new ZipArchive;
            if ($zip->open(storage_path('app/public/' . $this->folderPath.'/'.$this->zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
            {
                $files = Storage::disk('public')->files($this->folderPath);
                foreach ($files as $file) {
                    if (pathinfo($file, PATHINFO_EXTENSION) !== 'zip') {
                        $relativePath = substr($file, strlen($this->folderPath) + 1);
                        $zip->addFile(storage_path('app/public/' . $file), $relativePath);
                    }
                }
                $zip->close();
            }
            $user = User::find($this->user_id);
            // $link = Storage::url(storage_path('app/public/' . $this->folderPath.'/'.$this->zipFileName));
            $link = $this->staffUrl($user, $this->job_id);
            Notification::send($user, new ZipFileNotification($this->job_id, $link));
        } catch (\Exception $th) {
            Log::warning($th->getMessage());
        }
        
        
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == StaffType::ADMIN->value)
        {
            return route('admin.jobs.applicants.index', $id);
        }
        if($user->staff_type == StaffType::SUPERVISOR->value)
        {
            return route('supervisor.jobs.applicants.index', $id);
        }
        if($user->staff_type == StaffType::STAFF->value)
        {
            return route('staffs.jobs.applicants.index', $id);
        }
    }
}
