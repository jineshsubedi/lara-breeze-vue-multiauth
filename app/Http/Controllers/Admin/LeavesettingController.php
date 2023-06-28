<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\User;
use App\Models\Branch;
use App\Enums\AppConstant;
use App\Models\LeaveSetting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaveSettingRequest;

class LeavesettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = LeaveSetting::branchSetting()->with(['branch:id,name','hr:id,name','manager:id,name','handler:id,name']);
        $filter = $this->filterQuery($query);
        $leavesettings = $filter->latest('id')->paginate(15);
        $branches = Branch::branchList();
        return Inertia::render('Admin/Leavesetting/Index', [
            'leavesettings' => $leavesettings,
            'branches' => $branches,
            'filters' => $request->only(['branch_id'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::branchList();
        $datas['allow'] = AppConstant::ALLOW;
        $datas['required'] = AppConstant::REQUIRED;
        $datas['accrual'] = AppConstant::YN;
        return Inertia::render('Admin/Leavesetting/Create', [
            'branches' => $branches,
            'datas' => $datas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveSettingRequest $request)
    {
        LeaveSetting::updateOrCreate(['branch_id' => $request->branch_id], $request->validated());
        return redirect()->route('admin.leave_setting.index')->with('success', 'Branch Leave Setting Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveSetting $leaveSetting)
    {
        $branches = Branch::where('id', $leaveSetting->id)->get(['id', 'name']);
        $datas['allow'] = AppConstant::ALLOW;
        $datas['required'] = AppConstant::REQUIRED;
        $datas['accrual'] = AppConstant::YN;
        $datas['staffs'] = User::active()->branchId()->get(['id', 'name']);

        return Inertia::render('Admin/Leavesetting/Edit', [
            'branches' => $branches,
            'leaveSetting' => $leaveSetting,
            'datas' => $datas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeaveSettingRequest $request, LeaveSetting $leaveSetting)
    {
        $oldSetting = $leaveSetting;
        if($oldSetting->leave_handler != $request->leave_handler && $oldSetting->branch_id == $request->branch_id)
        {
            $user = new User;
            $role = new Role;
            $user1 = $user->select('id', 'name')->find($oldSetting->leave_handler);
            $user2 = $user->select('id', 'name')->find($request->leave_handler);
            if($role->where('name', 'LeaveManager')->first())
            {
                if(isset($user1->id))
                    $user1->removeRole('LeaveManager');
                if(isset($user2->id))
                    $user2->assignRole('LeaveManager');
            }
        }
        $leaveSetting->update($request->validated());
        return redirect()->route('admin.leave_setting.index')->with('success', 'Branch Leave Setting Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveSetting $leaveSetting)
    {
        $leaveSetting->delete();
        return redirect()->route('admin.leave_setting.index')->with('success', 'Branch Leave Setting Deleted');
    }

    private function filterQuery($query)
    {
        if(request()->filled('branch')) {
            $query->where('branch_id', request()->branch);
        }
        return $query;
    }
}
