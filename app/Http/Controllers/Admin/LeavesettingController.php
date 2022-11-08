<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaveSettingRequest;
use App\Models\Branch;
use App\Models\LeaveSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        $datas['staffs'] = User::active()->branch()->get(['id', 'name']);

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
