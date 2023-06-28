<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Http\Requests\Admin\JobsRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TemporaryFormRequest;
use App\Models\Branch;
use App\Models\Education;
use App\Models\Faculty;
use App\Models\JobEducation;
use App\Models\JobForm;
use App\Models\JobLevel;
use App\Models\JobLocation;
use App\Models\JobRequirements;
use App\Models\Jobs;
use App\Models\JobsLocation;
use App\Models\RecruitmentProcess;
use App\Models\TemporaryJobForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class JobsController extends Controller
{
    protected $disk = 'public';
    protected $path = 'jobs';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Jobs::query();
        $query->with(['branch:id,name', 'process:id,title'])->withCount('applications');
        $filter = $this->filterQuery($query);
        $jobs = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        return Inertia::render('Admin/Jobs/Index', [
            'jobs' => $jobs,
            'branches' => Branch::branchList(),
            'processes' => RecruitmentProcess::orderBy('id')->get(['id', 'title']),
            'statusss' => AppConstant::JOB_STATUS,
            'filters' => request()->only(['title', 'code', 'status', 'process', 'branch'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Jobs/Create', [
            'datas' => $this->getData()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Jobs\JobsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JobsRequest $request)
    {
        DB::beginTransaction();
        try {
            $job = Jobs::create($request->validated() + [
                'job_file' => $request->hasFile('jobFile') ? $request->file('jobFile')->store($this->path, $this->disk) : ''
            ]);
            if($request->job_location != null)
            {
                foreach($request->job_location as $loc)
                {
                    JobsLocation::create([
                        'jobs_id' => $job->id,
                        'job_location_id' => $loc
                    ]);
                }
            }
            JobRequirements::create([
                'jobs_id' => $job->id,
                'description' => $request->description,
                'specification' => $request->specification,
                'education_description' => $request->education_description,
                'specific_requirement' => $request->specific_requirement,
                'specific_instruction' => $request->specific_instruction
            ]);
            if (isset($request->educations) && count($request->educations) > 0) {
                foreach ($request->educations as $key => $value) {
                    if ($value['education_level_id'] != '') {
                        JobEducation::create([
                            'jobs_id' => $job->id,
                            'education_level_id' => $value['education_level_id'],
                            'faculty_id' => $value['faculty_id'],
                            'experience' => $value['experience'],
                            'exp_format' => $value['exp_format'],
                            'percent' => $value['percent'],
                            'cgpa' => $value['cgpa'],
                            'others' => $value['others'],
                        ]);
                    }
                }
            }
            $job_forms = TemporaryJobForm::where('session_id', session()->get('new_form'))->orderBy('id', 'asc')->get();
            foreach ($job_forms as $value) {
                $jf = TemporaryJobForm::where('id', $value->parent_id)->first();
                if (isset($jf->f_lable)) {
                    $jform = JobForm::where('jobs_id', $job->id)->where('f_lable', $jf->f_lable)->first();
                    if (isset($jform->id)) {
                    $parent_id = $jform->id;
                    } else{
                    $parent_id = 0;
                    }
                } else{
                    $parent_id = 0;
                }
                JobForm::create([
                    'jobs_id' => $job->id,
                    'parent_id' => $parent_id,
                    'f_lable' => $value->f_lable,
                    'f_type' => $value->f_type,
                    'list_menu' => $value->list_menu,
                    'required' => $value->required,
                    'marks' => $value->marks,
                    'extra' => $value->extra
                ]);
            }
            TemporaryJobForm::where('session_id', Session()->get('new_form'))->delete();
            session()->forget('new_form');
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            return back()->with('danger', $th->getMessage());
        }
        return redirect()->route('admin.jobs.index')->with('success', 'Job Post Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function show(Jobs $jobs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\JobsRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobs $job)
    {
        $job->load(['requirement', 'educations', 'locations', 'jobforms']);
        $job->jobforms->map(function($q){
            $q->parent = $q->parent;
            $q->require = $q->require;
            return $q;
        });
        $locations = $job->locations->pluck('job_location_id');
        $default_image = $job->advertise_image;
        return Inertia::render('Admin/Jobs/Edit', [
            'job' => $job,
            'locations' => $locations,
            'default_image' => $default_image,
            'datas' => $this->getData()
        ]);
    }

    public function update(JobsRequest $request, Jobs $job)
    {
        DB::beginTransaction();
        try {
            $job_file = $job->getRawOriginal('job_file');
            if($job_file != null && $request->hasFile('jobFile'))
            {
                $this->deleteJobFIle($job_file);
                $job_file = $request->file('jobFile')->store($this->path, $this->disk);
            }

            $job->update($request->validated() + [
                'job_file' => $job_file
            ]);

            if($request->job_location != null)
            {
                JobsLocation::where('jobs_id', $job->id)->delete();
                foreach($request->job_location as $loc)
                {
                    JobsLocation::create([
                        'jobs_id' => $job->id,
                        'job_location_id' => $loc
                    ]);
                }
            }
            JobRequirements::where('jobs_id', $job->id)->update([
                'description' => $request->description,
                'specification' => $request->specification,
                'education_description' => $request->education_description,
                'specific_requirement' => $request->specific_requirement,
                'specific_instruction' => $request->specific_instruction
            ]);
            if (isset($request->educations) && count($request->educations) > 0) {
                JobEducation::where('jobs_id', $job->id)->delete();
                foreach ($request->educations as $key => $value) {
                    if ($value['education_level_id'] != '') {
                        JobEducation::create([
                            'jobs_id' => $job->id,
                            'education_level_id' => $value['education_level_id'],
                            'faculty_id' => $value['faculty_id'],
                            'experience' => $value['experience'],
                            'exp_format' => $value['exp_format'],
                            'percent' => $value['percent'],
                            'cgpa' => $value['cgpa'],
                            'others' => $value['others'],
                        ]);
                    }
                }
            }
            $job_forms = TemporaryJobForm::where('session_id', session()->get('new_form'))->orderBy('id', 'asc')->get();
            foreach ($job_forms as $value) {
                $jf = TemporaryJobForm::where('id', $value->parent_id)->first();
                if (isset($jf->f_lable)) {
                    $jform = JobForm::where('jobs_id', $job->id)->where('f_lable', $jf->f_lable)->first();
                    if (isset($jform->id)) {
                    $parent_id = $jform->id;
                    } else{
                    $parent_id = 0;
                    }
                } else{
                    $parent_id = 0;
                }
                JobForm::create([
                    'jobs_id' => $job->id,
                    'parent_id' => $parent_id,
                    'f_lable' => $value->f_lable,
                    'f_type' => $value->f_type,
                    'list_menu' => $value->list_menu,
                    'required' => $value->required,
                    'marks' => $value->marks,
                    'extra' => $value->extra
                ]);
            }
            TemporaryJobForm::where('session_id', Session()->get('new_form'))->delete();
            session()->forget('new_form');
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            return $th;
            return back()->with('danger', $th->getMessage());
        }
        return redirect()->route('admin.jobs.index')->with('success', 'Job Post Added!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobs $job)
    {
        $job_file = $job->getRawOriginal('job_file');
        if($job_file != null)
        {
            $this->deleteJobFIle($job_file);
        }
        $job->delete();
        return back()->with('success', 'Record Deleted');
    }

    public function autocomplete(Request $request)
    {
        if (isset($request->term)) {
            $result = array();
            $data = TemporaryJobForm::where('f_lable', 'LIKE', $request->term.'%')
                ->where('session_id', session()->get('new_form'))
                ->skip(0)->take(10)
                ->get();
      
            $result[] = ['id' => '0', 'value' => 'Root'];
            foreach ($data as $key => $v) {
                $result[]=['value'=> $v->id, 'title'=> $v->f_lable];
            }
            return response()->json($result);
        }
    }
    public function addJobForm(TemporaryFormRequest $request)
    {
        TemporaryJobForm::create($request->validated() + [
            'session_id' => session()->get('new_form')
        ]);
        $forms = TemporaryJobForm::where('session_id', session()->get('new_form'))
                    ->skip(0)
                    ->take(10)
                    ->get()
                    ->map(function($q){
                        $q->parent = $q->parent;
                        $q->require = $q->require;
                        return $q;
                    });
        return response()->json($forms); 
    }
    public function deleteJobForm(Request $request): void
    {
        $form = TemporaryJobForm::findOrFail($request->id);
        $form->delete();
        return ;
    }
    public function deleteForm(Request $request): void
    {
        $form = JobForm::findOrFail($request->id);
        $form->delete();
        return ;
    }

    public function deleteJobFIle($job_file): void
    {
        if(Storage::exists($job_file))
            Storage::delete($job_file);
        return ;
    }

    private function filterQuery($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }else{
            if(request()->filled('branch')) {
                $query->where('branch_id', request()->branch);
            }
        }
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        if(request()->filled('code')) {
            $query->where('vacancy_code', 'LIKE', '%'.request()->code.'%');
        }
        if(request()->filled('status')) {
            $query->where('status', request()->status);
        }
        if(request()->filled('process')) {
            $query->where('process_status', request()->process);
        }
        return $query;
    }

    private function getData()
    {
        $data['branch'] = Branch::branchList();
        $data['joblevels'] = JobLevel::orderBy('order')->get(['id', 'name']);
        $data['joblocations'] = JobLocation::orderBy('name')->get(['id', 'name']);
        $data['jobavailabilty'] = AppConstant::JOB_AVAILABILITY;
        $data['minexperiences'] = AppConstant::MIN_EXPERIENCE;
        $data['negotiable'] = AppConstant::YN;
        $data['gender'] = AppConstant::PGENDER;
        $data['works'] = AppConstant::WORK_EXPERIENCE;
        $data['required'] = AppConstant::REQUIRED;
        $data['setting'] = AppConstant::JOB_SETTING;
        $data['status'] = AppConstant::JOB_STATUS;
        $data['process_status'] = RecruitmentProcess::orderBy('id')->get(['id', 'title']);
        $data['default_image'] = asset('images/no-image.png');
        $data['form_fields'] = AppConstant::JOB_FORMFIELDS;
        $data['job_type'] = AppConstant::JOB_TYPE;
        $data['exp_format'] = AppConstant::JOB_EXP_FORMAT;
        $data['form_type'] = AppConstant::FORM_FIELDS;
        $data['confidentiality'] = AppConstant::JOB_CONFIDENTIALITY;
        $data['education_level'] = Education::orderBy('title')->get(['id', 'title']);
        $data['faculty'] = Faculty::orderBy('title')->get(['id', 'title']);
        $data['vcode'] = rand(1, 9999);
        $data['today'] = Date('y-m-d');
        if (Session()->has('new_form')) {
            $data['forms'] = TemporaryJobForm::where('session_id', session()->get('new_form'))
                ->get()
                ->map(function($q){
                    $q->parent = $q->parent;
                    $q->require = $q->require;
                    return $q;
                });
        } else {
            Session(['new_form' => date('Ymdhis')]);
            $data['forms'] = [];
        }
        return $data;
    }

}

