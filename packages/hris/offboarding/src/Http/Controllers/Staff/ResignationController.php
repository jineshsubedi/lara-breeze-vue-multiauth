<?php

namespace Hris\Offboarding\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Hris\Offboarding\Enums\ResignationStatus;
use Hris\Offboarding\Models\OffboardSetting;
use Hris\Offboarding\Requests\ResignationApprovalRequest;
use Hris\Offboarding\Models\ResignationReason;
use Hris\Offboarding\Models\ResignationRetraction;
use Hris\Offboarding\Models\ResignationStaff;
use Hris\Offboarding\Models\ResignationType;
use Hris\Offboarding\Requests\ResignationStaffRequest;
use Hris\Offboarding\Requests\RetractionRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = ResignationStaff::query();
        if(request()->tab == 'approval')
        {
            $query->with(['user:id,name', 'type:id,title', 'reason:id,title'])
                ->where('supervisor', auth()->id());
        }else if(request()->tab == 'hrapproval'){
            $query->with(['user:id,name', 'type:id,title', 'reason:id,title'])
                ->where('supervisor_approval_status', ResignationStatus::APPROVED->value)
                ->where('status', 'pending');
        }else{
            $query->with(['type:id,title', 'reason:id,title', 'retraction'])
                ->where('user_id', auth()->id());
        }
        $filter = $this->filterQuery($query);
        $resignationstaffs = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        $resignationstaffs->map(function($q){
            $setting = OffboardSetting::where('branch_id', auth()->user()->branch_id)->first();
            if(isset($setting->id) && $q->retraction == null && $q->status == 'pending')
            {
                $retractionValidDate = Carbon::parse($q->supervisor_approval_date)->addDays($setting->retraction)->format('Y-m-d');
                if($retractionValidDate >= Date('Y-m-d'))
                    $q->retractAction = true;
                else
                    $q->retractAction = false;
            }else{
                $q->retractAction = false;
            }
            return $q;
        });
        return Inertia::render('Staff/Offboard/Resignation/Index', [
            'resignationstaffs' => $resignationstaffs,
            'resignation_status' => config('offboardConstant.resignation_status'),
            'retraction_status' => config('offboardConstant.retraction_status'),
            'filters' => request()->only(['staff', 'status', 'tab'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Offboard/Resignation/Create', [
            'datas' => $this->getData(),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResignationStaffRequest $request)
    {
        ResignationStaff::create($request->validated());
        return redirect()->route('staffs.resignations.index')->with('success', 'Record Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resignationstaff = ResignationStaff::findOrFail($id);
        $resignationstaff->load(['user:id,name', 'type:id,title', 'reason:id,title', 'authorize_user:id,name', 'retraction']);
        return Inertia::render('Staff/Offboard/Resignation/Show', [
            'resignationstaff' => $resignationstaff,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resignationstaff = ResignationStaff::findOrFail($id);
        return Inertia::render('Staff/Offboard/Resignation/Edit', [
            'resignationstaff' => $resignationstaff,
            'datas' => $this->getData()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResignationStaffRequest $request, $id)
    {
        $resignationstaff = ResignationStaff::findOrFail($id);
        $resignationstaff->update($request->validated());
        return redirect()->route('staffs.resignations.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resignationstaff = ResignationStaff::findOrFail($id);
        $resignationstaff->delete();
        return back()->with('success', 'Record Deleted');
    }

    public function approval(ResignationApprovalRequest $request)
    {
        $resignation = ResignationStaff::findOrFail($request->resignation_id);
        if($request->type == 'supervisor')
        {
            $resignation->update([
                'supervisor_approval_status' => $request->supervisor_approval_status,
                'supervisor_approval_detail' => $request->supervisor_approval_detail,
                'supervisor_approval_date' => Date('Y-m-d')
            ]);
        }else{
            $resignation->update([
                'status' => $request->supervisor_approval_status,
                'approval_detail' => $request->supervisor_approval_detail,
                'offBoarding_date' => $request->offBoarding_date,
                'approval_date' => Date('Y-m-d'),
                'approval_by' => auth()->id()
            ]);
        }
        return back()->with('success', 'Request Updated!');
    }

    public function retraction(RetractionRequest $request)
    {
        ResignationRetraction::create($request->validated());
        return back()->with('success', 'Request Submitted!');
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
