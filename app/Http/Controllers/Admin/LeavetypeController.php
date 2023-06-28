<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeavetypeRequest;
use App\Models\Branch;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeavetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::branchList();
        $query = LeaveType::query();
        $query->with(['branch:id,name']);
        $filter = $this->filterQuery($query);
        $ltypes = $filter->latest('id', 'desc')->paginate(15)->withQueryString();
        return Inertia::render('Admin/Leavetype/Index', [
            'ltypes' => $ltypes,
            'branches' => $branches,
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
        $datas['accrual'] = AppConstant::YN;
        $datas['extra'] = [
            ['value' => 0, 'title' => 'Date'],
            ['value' => 1, 'title' => 'File'],
        ];
        return Inertia::render('Admin/Leavetype/Create',[
            'branches' => $branches,
            'datas' => $datas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeavetypeRequest $request)
    {
        foreach($request->leave_type as $st)
        {
            $data = [
                'branch_id' => $request->branch_id,
                'title' => $st['title'],
                'days' => $st['days'],
                'apply_before' => $st['apply_before'],
                'eligible' => $st['eligible'],
                'continuous' => $st['continuous'],
                'accrual' => $st['accrual'],
                'accrual_basis' => $st['accrual_basis'],
                'is_extra' => $st['is_extra'],
            ];
            LeaveType::create($data);
        }
        return redirect()->route('admin.leave_types.index')->with('success', 'Leave Type Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveType $leaveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveType $leaveType)
    {
        $datas['accrual'] = AppConstant::YN;
        $datas['extra'] = [
            ['value' => 0, 'title' => 'Date'],
            ['value' => 1, 'title' => 'File'],
        ];
        return Inertia::render('Admin/Leavetype/Edit', [
            'leaveType' => $leaveType,
            'datas' => $datas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeavetypeRequest $request, LeaveType $leaveType)
    {
        $leaveType->update($request->validated());
        return redirect()->route('admin.leave_types.index')->with('success', 'Leave Type Added Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();
        return back()->with('success', 'Leave Type Deleted Successfully!');
    }

    private function filterQuery($query)
    {
        if(request()->filled('branch')) {
            $query->where('branch_id', request()->branch);
        }
        return $query;
    }
}
