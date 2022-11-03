<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BranchRequest;
use App\Http\Requests\Admin\BranchSettingRequest;
use App\Library\Imagetool;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Branch;
use App\Models\BranchSetting;
use App\Models\Department;
use App\Models\PerformanceSetting;
use App\Models\User;
use Inertia\Inertia;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Branch::query();
        $query->with(['province:id,title','district:id,title']);
        $filter = $this->filterQuery($query);
        $branches = $filter->latest('id')->paginate(15);
        $provinces = Province::titleList();
        $districts = District::when($request->province, function($q){
            return $q->where('province_id', request('province'));
        })->titleList();

        return Inertia::render('Admin/Branch/Index', [
            'branches' => $branches,
            'provinces' => $provinces,
            'districts' => $districts,
            'filters' => $request->only(['province', 'district'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::titleList();
        $yn = AppConstant::YN;

        return Inertia::render('Admin/Branch/Create', [
            'provinces' => $provinces,
            'yn' => $yn,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        Branch::create($request->validated());
        return redirect()->route('admin.branches.index')->with('success', 'Branch Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        return $branch;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $provinces = Province::titleList();
        $yn = AppConstant::YN;
        return Inertia::render('Admin/Branch/Edit', [
            'branch' => $branch,
            'provinces' => $provinces,
            'yn' => $yn,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());
        return redirect()->route('admin.branches.index')->with('success', 'Branch Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        if ($branch->is_head == 1)
        {
            return back()->with('danger', 'Head Branch Cannot be Deleted!');
        }
        $branch->delete();
        return back()->with('success', 'Branch Deleted Successfully!');
    }

    private function filterQuery($query)
    {
        if(request()->filled('province')) {
             $query->where('province_id', request()->province);
        }
        if(request()->filled('district')) {
            $query->where('district_id', request()->district);
        }
        return $query;
    }

    public function getSetting($id)
    {
        $branch = Branch::with(['setting', 'performance'])->findOrFail($id);
        $yn = AppConstant::YN;
        $duration = AppConstant::DURATION;
        $rating_times = AppConstant::RATING_TIMES;
        $lang_dates = AppConstant::LANG_DATE;
        $client_ratings = AppConstant::CLIENT_RATING;
        $titles = AppConstant::PERFORMANCE_TITLES;
        $staffs = User::where('branch_id', $id)->active()->get(['id', 'name']);
        $departments = Department::where('branch_id', $id)->get(['id', 'title']);

        $setting = [
            'revenue' => isset($branch->setting->id) ? $branch->setting->revenue : null,
            'client' => isset($branch->setting->id) ? $branch->setting->client : null,
            'canteen' => isset($branch->setting->id) ? $branch->setting->canteen : null,
            'client_comment' => isset($branch->setting->id) ? $branch->setting->client_comment : 0,
            'comment_type' => isset($branch->setting->id) ? $branch->setting->comment_type : 0,
            'salary_calculate' => isset($branch->setting->id) ? $branch->setting->salary_calculate : 1,
            'performance_rater' => isset($branch->setting->id) ? $branch->setting->performance_rater : null,
            'performance_rating_type' => isset($branch->setting->id) ? $branch->setting->performance_rating_type : null,    
            'attendance_handler' => isset($branch->setting->id) ? $branch->setting->attendance_handler : null,
            'hr_handler' => isset($branch->setting->id) ? $branch->setting->hr_handler : null,
            'training_handler' => isset($branch->setting->id) ? $branch->setting->training_handler : null,
            'staff_handler' => isset($branch->setting->id) ? $branch->setting->staff_handler : null,
            'survey_handler' => isset($branch->setting->id) ? $branch->setting->survey_handler : null,
            'out_source_handler' => isset($branch->setting->id) ? $branch->setting->out_source_handler : [],
            'account_handler_signature' => isset($branch->setting->id) ? $branch->setting->account_handler_signature : null,
            'account_handler' => isset($branch->setting->id) ? $branch->setting->account_handler : null,
        ];
        
        $defaultImage = isset($branch->setting->id) ? Imagetool::mycrop($branch->setting->account_handler_signature, 100, 100) : Imagetool::mycrop('no-image.png', 100, 100);
        
        return Inertia::render('Admin/Branch/Setting', [
            'branch' => $branch,
            'duration' => $duration,
            'rating_times' => $rating_times,
            'lang_dates' => $lang_dates,
            'client_ratings' => $client_ratings,
            'staffs' => $staffs,
            'departments' => $departments,
            'yn' => $yn,
            'titles' => $titles,
            'setting' => $setting,
            'defaultImage' => $defaultImage,
            'performance' => count($branch->performance) > 0 ? $branch->performance : []
        ]);
    }

    public function storeSetting(BranchSettingRequest $request, $id)
    {
        $branch = Branch::with(['setting', 'performance'])->findOrFail($id);
        BranchSetting::updateOrCreate(
            ['branch_id' => $branch->id],
            $request->validated(),
            [
                'branch_id' => $branch->id,
                'out_source_handler' => $request->out_source_handler
            ]
        );
        if($request->performance)
        {
            PerformanceSetting::where('branch_id', $branch->id)->delete();
            foreach($request->performance as $per)
            {
                PerformanceSetting::create([
                    'branch_id' => $branch->id,
                    'title' => $per['title'],
                    'duration' => $per['duration'],
                    'parameter' => $per['parameter'],
                ]);
            }
        }
        return back()->with('success', 'Branch Setting Updated!');
    }
}
