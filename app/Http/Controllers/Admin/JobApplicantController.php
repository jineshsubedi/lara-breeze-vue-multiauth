<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobApplicationProcessRequest;
use App\Jobs\JobZipFiles;
use App\Models\Applicant;
use App\Models\ApplicationProcess;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class JobApplicantController extends Controller
{
    public function index($id)
    {
        $job = Jobs::findOrFail($id);
        $job->load(['applicantProcess']);
        $query = Applicant::query();
        $filter = $this->filterQuery($query);
        $applications = $filter->latest('id', 'desc')
                          ->paginate(50)
                          ->withQueryString();
        return Inertia::render('Admin/Jobs/Applications', [
            'job' => $job,
            'data' => $this->getData($job),
            'applications' => $applications,
            'default_email_text' => AppConstant::JOB_DEFAULT_EMAIL_TEXT,
            'filters' => request()->only(['name', 'email', 'code'])
        ]);
    }
    public function application_process($id, JobApplicationProcessRequest $request)
    {
        $job = Jobs::findOrFail($id);
        ApplicationProcess::create($request->validated() + [
            'jobs_id' => $job->id
        ]);
        return back()->with('success', 'Application Process Added');
    }
    public function process($id, $process_id)
    {
        $job = Jobs::findOrFail($id);
        $job->load(['applicantProcess']);
        $process = ApplicationProcess::findOrFail($process_id);
        $query = Applicant::query();
        $query->where('jobs_id', $job->id)
                ->whereIn('id', $process->candidate);
        $filter = $this->filterQuery($query);
        $applications = $filter->latest('id', 'desc')
                          ->paginate(50)
                          ->withQueryString();
        return Inertia::render('Admin/Jobs/ProcessApplication', [
            'job' => $job,
            'data' => $this->getData($job),
            'process' => $process,
            'applications' => $applications,
            'default_email_text' => AppConstant::JOB_DEFAULT_EMAIL_TEXT,
        ]);
    }
    public function update_process($id, $process_id, JobApplicationProcessRequest $request)
    {
        $job = Jobs::findOrFail($id);
        $process = ApplicationProcess::findOrFail($process_id);
        if($job->id == $process->jobs_id)
        {
            $process->update($request->validated());
            return back()->with('success', 'Application Process Updated');
        }
        return back()->with('danger', 'Application Process Could not be Updated');
    }
    public function delete_process($id, $process_id)
    {
        $job = Jobs::findOrFail($id);
        $process = ApplicationProcess::findOrFail($process_id);
        if($job->id == $process->jobs_id)
        {
            $process->delete();
            return back()->with('success', 'Process Deleted');
        }
        return back()->with('danger', 'Process Unable Deleted');
    }
    public function update_candidate($id, Request $request)
    {
        $job = Jobs::findOrFail($id);
        $process = ApplicationProcess::findOrFail($request->process_id);
        if($job->id == $process->jobs_id)
        {
            $result = array_unique(array_merge($process->candidate, $request->candidate));
            $process->update(['candidate' => $result]);
            return back()->with('success', 'Candidate Transfered!');
        }
        return back()->with('danger', 'Unable to Transfer Candidate');
    }
    public function showApplicant($id, $applicant)
    {
        $job = Jobs::findOrFail($id);
        $applicant = Applicant::findOrFail($applicant);
        $applicant->load(['education', 'address', 'training', 'language', 'reference', 'experience']);
        return Inertia::render('Admin/Jobs/Applicant', [
            'job' => $job,
            'applicant' => $applicant
        ]);
    }
    public function downloadCV($id)
    {
        $job = Jobs::findOrFail($id);
        $folderPath = 'jobs/'.$job->vacancy_code.'/cv'; 
        $zipFileName = $job->vacancy_code.'-allCV.zip';

        JobZipFiles::dispatch($folderPath, $zipFileName, auth()->id(), $job->id);
        return back()->with('success', 'CV Zip file created and queued for processing.');
    }
    public function downloadCover($id)
    {
        $job = Jobs::findOrFail($id);
        $folderPath = 'jobs/'.$job->vacancy_code.'/cover'; 
        $zipFileName = $job->vacancy_code.'-allCover.zip';

        JobZipFiles::dispatch($folderPath, $zipFileName, auth()->id(), $job->id);
        return back()->with('success', 'Cover Zip file created and queued for processing.');
    }
    public function getData($job)
    {
        $data['cv'] = null;
        $data['cover'] = null;
        if(Storage::exists('jobs/'.$job->vacancy_code.'/cv/'.$job->vacancy_code.'-allCV.zip'))
        {
            $data['cv'] = Storage::url('jobs/'.$job->vacancy_code.'/cv/'.$job->vacancy_code.'-allCV.zip');
        }
        if(Storage::exists('jobs/'.$job->vacancy_code.'/cover/'.$job->vacancy_code.'-allCover.zip'))
        {
            $data['cover'] = Storage::url('jobs/'.$job->vacancy_code.'/cover/'.$job->vacancy_code.'-allCover.zip');
        }
        return $data;
    }
    private function filterQuery($query)
    {
        if(request()->filled('name')) {
            $query->where('first_name', 'LIKE', '%'.request()->name.'%');
        }
        if(request()->filled('email')) {
            $query->where('email', 'LIKE', '%'.request()->email.'%');
        }
        if(request()->filled('code')) {
            $query->where('tracking_code', 'LIKE', '%'.request()->code.'%');
        }
        return $query;
    }
}
