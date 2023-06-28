<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Enums\PerformanceTitle;
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
use Spatie\Permission\Models\Role;

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
        $branches = $filter->latest('id')->paginate(15)->withQueryString();
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
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('id', auth()->user()->branch_id);
        }
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
        $titles = [
            PerformanceTitle::TASK->value,
            PerformanceTitle::KPI->value,
            PerformanceTitle::DISCIPLINE->value,
            PerformanceTitle::PUNCTUALITY->value,
            PerformanceTitle::SUBORDINATE_RATING->value,
            PerformanceTitle::ACHIEVEMENT->value,
        ];
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
        
        $defaultImage = isset($branch->setting->id) ? Imagetool::mycrop($branch->setting->account_handler_signature ? $branch->setting->account_handler_signature : 'no-image.png', 100, 100) : Imagetool::mycrop('no-image.png', 100, 100);

        $defaultTitles = [];
        foreach($titles as $t)
        {
            $defaultTitles[] = [
                'title' => $t,
                'duration' => '',
                'parameter' => ''
            ];
        }
        
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
            'performance' => count($branch->performance) > 0 ? $branch->performance : $defaultTitles
        ]);
    }

    public function storeSetting(BranchSettingRequest $request, $id)
    {
        $branch = Branch::with(['setting', 'performance'])->findOrFail($id);
        $old_setting = BranchSetting::where('branch_id', $branch->id)->first();
        $setting = BranchSetting::updateOrCreate(
            ['branch_id' => $branch->id],
            $request->validated(),
            [
                'branch_id' => $branch->id,
                'out_source_handler' => $request->out_source_handler
            ]
        );
        if(isset($old_setting->id))
            $this->assignBranchRoles($setting, $old_setting);
            
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
    public function assignBranchRoles($setting, $old_setting)
    {
        $user = new User;
        $role = new Role;
        if($old_setting->out_source_handler != $setting->out_source_handler && $old_setting->branch_id == $setting->branch_id)
        {
            foreach($old_setting->out_source_handler as $handler)
            {
                $user = $user->select('id', 'name')->find($handler);
                if($role->where('name', 'OutSourceHandler')->first())
                    $user->removeRole('OutSourceHandler');
            }
            foreach($setting->out_source_handler as $handler)
            {
                $user = $user->select('id', 'name')->find($handler);
                if($role->where('name', 'OutSourceHandler')->first())
                    $user->assignRole('OutSourceHandler');
            }
        }
        if($old_setting->attendance_handler != $setting->attendance_handler && $old_setting->branch_id == $setting->branch_id)
        {
            $user1 = $user->select('id', 'name')->find($old_setting->attendance_handler);
            $user2 = $user->select('id', 'name')->find($setting->attendance_handler);
            if($role->where('name', 'AttendanceHandler')->first())
                $this->roleAssignment($user1, $user2, 'AttendanceHandler');
        }
        if($old_setting->hr_handler != $setting->hr_handler && $old_setting->branch_id == $setting->branch_id)
        {
            $user1 = $user->select('id', 'name')->find($old_setting->hr_handler);
            $user2 = $user->select('id', 'name')->find($setting->hr_handler);
            if($role->where('name', 'HrHandler')->first())
                $this->roleAssignment($user1, $user2, 'HrHandler');
        }
        if($old_setting->account_handler != $setting->account_handler && $old_setting->branch_id == $setting->branch_id)
        {
            $user1 = $user->select('id', 'name')->find($old_setting->account_handler);
            $user2 = $user->select('id', 'name')->find($setting->account_handler);
            if($role->where('name', 'PayrollHandler')->first())
                $this->roleAssignment($user1, $user2, 'PayrollHandler');
        }
        if($old_setting->staff_handler != $setting->staff_handler && $old_setting->branch_id == $setting->branch_id)
        {
            $user1 = $user->select('id', 'name')->find($old_setting->staff_handler);
            $user2 = $user->select('id', 'name')->find($setting->staff_handler);
            if($role->where('name', 'StaffHandler')->first())
                $this->roleAssignment($user1, $user2, 'StaffHandler');
        }
        if($old_setting->training_handler != $setting->training_handler && $old_setting->branch_id == $setting->branch_id)
        {
            $user1 = $user->select('id', 'name')->find($old_setting->training_handler);
            $user2 = $user->select('id', 'name')->find($setting->training_handler);
            if($role->where('name', 'TrainingHandler')->first())
                $this->roleAssignment($user1, $user2, 'TrainingHandler');
        }
        if($old_setting->survey_handler != $setting->survey_handler && $old_setting->branch_id == $setting->branch_id)
        {
            $user1 = $user->select('id', 'name')->find($old_setting->survey_handler);
            $user2 = $user->select('id', 'name')->find($setting->survey_handler);
            if($role->where('name', 'SurveyHandler')->first())
                $this->roleAssignment($user1, $user2, 'SurveyHandler');
        }
        if($old_setting->revenue != $setting->revenue && $old_setting->branch_id == $setting->branch_id)
        {
            $user1 = $user->select('id', 'name')->find($old_setting->revenue);
            $user2 = $user->select('id', 'name')->find($setting->revenue);
            if($role->where('name', 'RevenueHandler')->first())
                $this->roleAssignment($user1, $user2, 'RevenueHandler');
        }
    }
    private function roleAssignment($user1, $user2, $role)
    {
        if(isset($user1->id))
            $user1->removeRole($role);
        if(isset($user2->id))
            $user2->assignRole($role);
    }
}
