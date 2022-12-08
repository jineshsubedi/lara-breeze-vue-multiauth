<?php

namespace App\Http\Controllers\Supervisor;

use App\Services\LeaveRequestService;
use App\Services\LeaveSettingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveRequest;
use App\Models\CompensatoryOff;
use App\Models\LeaveHandover;
use App\Models\LeaveSetting;
use Illuminate\Http\Request;
use App\Models\FiscalYear;
use App\Models\LeaveType;
use App\Models\Branch;
use App\Models\Leave;
use App\Models\User;
use Inertia\Inertia;
use Carbon\Carbon;

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
        $query->with(['user:id,name','branch:id,name', 'leaveType:id,title']);
        $filter = $this->filterQuery($query);
        $leaves = $filter->latest('id')->paginate(20)->withQueryString();
        $branches = Branch::branchList();
        $staffs = User::active()->where('branch_id', $branchId)->get(['id', 'name']);
        return Inertia::render('Supervisor/Leave/Index', [
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
    public function create(LeaveRequestService $leaveRequest, LeaveSettingService $leaveSetting)
    {
        $branchId = auth()->user()->branch_id;
        $staffs = User::active()
            ->where('branch_id', $branchId)
            ->where('id', '!=', auth()->id())
            ->get(['id', 'name']);
        $datas = $this->getFormData($branchId, $leaveRequest, $leaveSetting);
        return Inertia::render('Supervisor/Leave/Create', [
            'staffs' => $staffs,
            'datas' => $datas,
            'defBranch' => fn () => $branchId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveRequest $request)
    {
        $leave = Leave::create($request->validated());
        $this->updateApproval($leave);
        LeaveHandover::create([
            'leave_id' => $leave->id,
            'user_id' => $request->handover_staff,
            'status' => '0'
        ]);
        return redirect()->route('supervisor.leaves.index')->with('success', 'Leave Requested Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->load(['user:id,name','branch:id,name', 'leaveType:id,title']);
        $leave->document = $leave->document_path;
        $leave->type = Leave::getTypeLabel($leave->type);
        return Inertia::render('Supervisor/Leave/Show', [
            'leave' => $leave
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return back()->with('success', 'Leave Request Deleted');
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
        if(request()->filled('from'))
        {
            $query->whereDate('start_date', '<=', request()->from);
        }
        if(request()->filled('to'))
        {
            $query->whereDate('end_date', '>=', request()->to);
        }
        if(request()->type == 1) // for my leave request
        {
            $query->where('user_id', auth()->id());
        }
        else if(request()->type == 2) // for leave approval supervisor
        {
            $subOrdinates = User::where('supervisor_id', auth()->id())->pluck('id');
            $query->whereIn('user_id', $subOrdinates)->where('s_approve', '0');
        }
        else if(request()->type == 3) // for leave approval HR
        {
            $query->where('s_approve', '1')->where('h_approve', '0');
        }
        else if(request()->type == 4) // for leave approval Chairman
        {
            $query->where('h_approve', '1')->where('m_approve', '0');
        }
        else{
        }
        $subIds = User::where('supervisor_id', auth()->id())->orWhere('id', auth()->id())->pluck('id');
        $query->whereIn('user_id', $subIds);
        return $query;
    }

    public function updateApproval($leave)
    {
        $setting = LeaveSetting::where('branch_id', auth()->user()->branch_id)->first();
        if(isset($setting->id))
        {
            $leave->update([
                's_approve' => $setting->s_approval == '1' ? '0' : '1',
                'h_approve' => $setting->h_approval == '1' ? '0' : '1',
                'm_approve' => $setting->m_approval == '1' ? '0' : '1',
            ]);
        }else{
            $leave->update([
                's_approve' => '1',
                'h_approve' => '1',
                'm_approve' => '1',
            ]);
        }
    }

    private function getFormData($branch, $leaveService, $leaveSettingService)
    {
        $authUser = request()->user();
        $leaveSetting = $leaveSettingService->getApprovalPersons($branch);
        $leaveTypes = LeaveType::where('branch_id', $branch)->get();
        $fiscalYear = FiscalYear::where('current_year', '1')->first();
        foreach ($leaveTypes as $leaveType) {
            $totalFullRequest = $leaveService->countLeaveRequest(
                userId: $authUser->id,
                leaveTypeId: $leaveType->id,
                startDate: $fiscalYear->start_date,
                endDate: $fiscalYear->end_date,
                leaveNature: Leave::LEAVE_NATURE_FULL

            );
            $totalHalfRequest = $leaveService->countLeaveRequest(
                userId: $authUser->id,
                leaveTypeId: $leaveType->id,
                startDate: $fiscalYear->start_date,
                endDate: $fiscalYear->end_date,
                leaveNature: Leave::LEAVE_NATURE_HALF
            );

            $totalQuarterRequest = $leaveService->countLeaveRequest(
                userId: $authUser->id,
                leaveTypeId: $leaveType->id,
                startDate: $fiscalYear->start_date,
                endDate: $fiscalYear->end_date,
                leaveNature: Leave::LEAVE_NATURE_QUARTER
            );

            $lastYear = Carbon::parse($fiscalYear->start_date)->subDays(1);
            $previousLeaveRequest = $leaveService->prevLeaveRequest(
                userId: $authUser->id,
                leaveTypeId: $leaveType->id,
                lastYear: $lastYear,
            );


            if ($previousLeaveRequest) {
                $endDate = Carbon::parse($previousLeaveRequest->end_date);
                $startDate = Carbon::parse($lastYear);
                $days = $endDate->diffInDays($startDate);

                switch ($previousLeaveRequest->type) {

                    case Leave::LEAVE_NATURE_FULL:
                        $totalPrevLeave = $days;
                        break;

                    case Leave::LEAVE_NATURE_HALF:
                        $totalPrevLeave = $days / 2;
                        break;

                    case Leave::LEAVE_NATURE_QUARTER:
                        $totalPrevLeave = $days / 4;
                        break;
                }

            } else {
                $totalPrevLeave = 0;
            }

            $halfRequest = $totalHalfRequest / 2;
            $quarterRequest = $totalQuarterRequest / 4;
            $totalLeaveRequest = $totalFullRequest + $totalPrevLeave + $halfRequest + $quarterRequest;
            $eligibleDate = Carbon::parse($authUser->join_date)
                ->addMonths($leaveType->eligible);

            $totalAccrual = 0;
            $remainingLeave = 0;

            if ($eligibleDate->toDateString() > $fiscalYear->start_date) {

                $fiscalYearEndDate = Carbon::parse($fiscalYear->end_date);

                $totalMonth = Carbon::parse($authUser->join_date)
                    ->addMonths($leaveType->eligible)
                    ->diffInMonths($fiscalYearEndDate);
                $perMonthAllow = $leaveType->days / 12;
                $allowDays = $perMonthAllow * $totalMonth;

                if ($allowDays > $totalLeaveRequest) {
                    $remainingLeave = $allowDays - $totalLeaveRequest;
                }
                $months = $eligibleDate->diffInMonths(Carbon::now());

                $months++;

                $totalAccrual = ($months * $perMonthAllow) - $totalLeaveRequest;

            } else {

                $allowDays = $leaveType->days;

                if ($allowDays > $totalLeaveRequest) {
                    $remainingLeave = $allowDays - $totalLeaveRequest;
                }

                $months = Carbon::parse($fiscalYear->start_date)->diffInMonths(Carbon::now());
                $months++;
                $perMonthAllow = $leaveType->days / 12;
                $totalAccrual = ($months * $perMonthAllow) - $totalLeaveRequest;
            }

            $accrual = 0;
            $accuralTitle = '';
            if ($leaveType->accrual_basis == 1) {
                $accrual = $totalAccrual;
                $accuralTitle = 'Remaining Accrual(' . number_format($totalAccrual, 2) . ')';
            }

            $data['leaveTypes'][] = [
                'id' => $leaveType->id,
                'title' => $leaveType->title . ' - Total Allow(' . number_format($allowDays, 2) . ') Remaining Leave(' . number_format($remainingLeave, 2) . ') ' . $accuralTitle,
                'remaining' => $remainingLeave,
                'accrual' => $accrual,
                'continuous_leave' => $leaveType->continuous,
                'eligible' => $leaveType->eligible,
                'apply_before' => $leaveType->apply_before,
                'is_extra' => $leaveType->is_extra
            ];
        }
        $data['leaveNatures'] = $leaveSettingService->getAllowedLeaveNatures($branch);
        $data['leaveSetting'] = $leaveSetting;
        $today = Carbon::now();


        $data['joinduration'] = Carbon::parse($authUser->join_date)->diffInMonths($today);
        $data['compensatory_off'] = CompensatoryOff::select('work_day')->where('user_id',$authUser->id)->where('status', '1')->where('leave_status', '0')->get();

        $data['handover_required'] = $leaveSetting['handover'];

        return $data;
    }

    public function approval($id, Request $request)
    {
        $leave = Leave::findOrFail($id);
        $leave->update([
            's_approve' => $request->s_approve,
            'h_approve' => $request->h_approve,
            'm_approve' => $request->m_approve
        ]);
        return back()->with('Success', 'Leave Request Updated');
    }
}
