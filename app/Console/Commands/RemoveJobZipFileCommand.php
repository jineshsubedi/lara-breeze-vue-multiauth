<?php

namespace App\Console\Commands;

use App\Models\Jobs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RemoveJobZipFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobZipFile:Remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Job Zip File';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobs = Jobs::where('status', 1)->get(['id', 'title', 'vacancy_code']);
        foreach($jobs as $job)
        {
            if(Storage::exists('jobs/'.$job->vacancy_code.'/cv/'.$job->vacancy_code.'-allCV.zip'))
                Storage::delete('jobs/'.$job->vacancy_code.'/cv/'.$job->vacancy_code.'-allCV.zip');
            if(Storage::exists('jobs/'.$job->vacancy_code.'/cover/'.$job->vacancy_code.'-allCover.zip'))
                Storage::delete('jobs/'.$job->vacancy_code.'/cover/'.$job->vacancy_code.'-allCover.zip');
        }
        return Command::SUCCESS;
    }
}
