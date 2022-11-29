<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Leave;
use App\Models\LeaveSetting;
use App\Models\LeaveType;
use App\Models\User;
use App\Services\LeaveSettingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaveController extends Controller
{
    protected $disk = 'public';
    protected $path = 'leave_documents';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LeaveSettingService $leaveRequest)
    {
        $branchId = auth()->user()->branch_id;
        $query = Leave::query();
        $query->with(['user:id,name','branch:id,name']);
        $filter = $this->filterQuery($query);
        $leaves = $filter->latest('id')->paginate(20)->withQueryString();
        $branches = Branch::branchList();
        $staffs = User::active()->where('branch_id', $branchId)->get(['id', 'name']);
        return Inertia::render('Admin/Leave/Index', [
            'leaves' => $leaves,
            'branches' => $branches,
            'staffs' => $staffs,
            'leaveSetting' => $leaveRequest->getApprovalPersons($branchId),
            'countData' => $leaveRequest->getCountApprovalList($branchId),
            'defBranch' => fn () => $branchId,
            'filters' => $request->only(['staff', 'from', 'to', 'type'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LeaveSettingService $leaveRequest)
    {
        $branchId = auth()->user()->branch_id;
        $staffs = User::active()->where('branch_id', $branchId)->get(['id', 'name']);
        $datas = $this->getFormData($branchId, $leaveRequest);
        return $datas;
        return Inertia::render('Admin/Leave/Create', [
            'staffs' => $staffs,
            'defBranch' => fn () => $branchId,
        ]);
    }
    private function getFormData($branch, $leaveRequest)
    {
        $leaveSetting = $leaveRequest->getApprovalPersons($branch);
        $leaveTypes = LeaveType::where('branch_id', $branch)->get();
        // $fiscalYear = FiscalYear::where('current_year', '1')->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function filterQuery($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }
        if(request()->filled('branch') && auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', request()->branch);
        }
        if(request()->filled('staff'))
        {
            $query->where('user_id', request()->staff);
        }
        if(request()->type == 1) // for my leave request
        {
            $query->where('user_id', auth()->id());
        }
        else if(request()->type == 2) // for leave approval supervisor
        {
            $subOrdinates = User::where('supervisor_id', auth()->id())->pluck('id');
            $query->whereIn('user_id', $subOrdinates)->where('s_approve', 0);
        }
        else if(request()->type == 3) // for leave approval HR
        {
            $query->where('s_approve', 1)->where('h_approve', 0);
        }
        else if(request()->type == 4) // for leave approval Chairman
        {
            $query->where('s_approve', 1)->where('h_approve', 1)->where('m_approve', 0);
        }
        else{
        }
        return $query;
    }
}
