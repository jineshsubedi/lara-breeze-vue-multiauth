<?php

namespace Hris\Offboarding\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hris\Offboarding\Enums\ResignationStatus;
use Hris\Offboarding\Models\ResignationReason;
use Hris\Offboarding\Models\ResignationRetraction;
use Hris\Offboarding\Models\ResignationStaff;
use Hris\Offboarding\Models\ResignationType;
use Hris\Offboarding\Requests\ResignationStaffRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResignationStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:HrHandler');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = ResignationStaff::query();
        $query->with(['user:id,name', 'type:id,title', 'reason:id,title', 'retraction']);
        $filter = $this->filterQuery($query);
        $resignationstaffs = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Staff/Offboard/ResignationStaffs/Index', [
            'resignationstaffs' => $resignationstaffs,
            'resignation_status' => config('offboardConstant.resignation_status'),
            'filters' => request()->only(['staff', 'status'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Offboard/ResignationStaffs/Create', [
            'datas' => $this->getData()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ResignationStaff\ResignationStaffRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ResignationStaffRequest $request)
    {
        ResignationStaff::create($request->validated());
        return redirect()->route('staffs.resignationstaffs.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResignationStaff  $resignationstaff
     * @return \Illuminate\Http\Response
     */
    public function show(ResignationStaff $resignationstaff)
    {
        $resignationstaff->load(['user:id,name', 'type:id,title', 'reason:id,title', 'authorize_user:id,name', 'retraction']);
        return Inertia::render('Staff/Offboard/ResignationStaffs/Show', [
            'resignationstaff' => $resignationstaff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ResignationStaffRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResignationStaff  $resignationstaff
     * @return \Illuminate\Http\Response
     */
    public function edit(ResignationStaff $resignationstaff)
    {
        return Inertia::render('Staff/Offboard/ResignationStaffs/Edit', [
            'resignationstaff' => $resignationstaff,
            'datas' => $this->getData()
        ]);
    }

    public function update(ResignationStaffRequest $request, ResignationStaff $resignationstaff)
    {
        $resignationstaff->update($request->validated());
        return redirect()->route('staffs.resignationstaffs.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResignationStaff  $resignationstaff
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResignationStaff $resignationstaff)
    {
        $resignationstaff->delete();
        return back()->with('success', 'Record Deleted');
    }

    public function retraction_approval(Request $request)
    {
        $this->validate($request, [
            'resignation_id' => 'required',
            'description' => 'required',
            'hr_approval' => 'required',
            'hr_remark' => 'required'
        ]);
        $retract = ResignationRetraction::where('resignation_staffs_id', $request->resignation_id)->firstOrFail();
        $retract->update([
            'hr_approval' => $request->hr_approval,
            'hr_remark' => $request->hr_remark,
        ]);
        $rr = $request->hr_approval == ResignationStatus::APPROVED->value ? 1 : 2;
        ResignationStaff::find($request->resignation_id)->update(['retract' => $rr]);
        return back()->with('success', 'Retarction Status Updated');
    }

    private function getData()
    {
        $data['staffs'] = User::active()->branchId()->get(['id', 'name']);
        $data['types'] = ResignationType::branchId()->get(['id', 'title']);
        $data['reasons'] = ResignationReason::branchId()->get(['id', 'title']);
        return $data;
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
        return $query;
    }

}

