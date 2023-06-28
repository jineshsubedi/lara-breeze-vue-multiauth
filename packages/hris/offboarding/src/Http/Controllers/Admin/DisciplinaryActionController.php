<?php

namespace Hris\Offboarding\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hris\Offboarding\Models\DisciplinaryAction;
use Hris\Offboarding\Models\DisciplinaryGround;
use Hris\Offboarding\Requests\DisciplinaryActionRequest;
use Hris\Offboarding\Enums\OffboardActionType;
use Hris\Offboarding\Enums\TerminationStatus;
use Hris\Offboarding\Models\TerminationStaff;
use Hris\Offboarding\Models\TerminationType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DisciplinaryActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:HrHandler|SuperAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DisciplinaryAction::query();
        $query->with(['branch:id,name','user:id,name','isseudby:id,name', 'grounds:id,title']);
        $filter = $this->filterQuery($query);
        $disciplinaryactions = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        return Inertia::render('Admin/Offboard/DisciplinaryActions/Index', [
            'disciplinaryactions' => $disciplinaryactions,
            'terminationStatus' => config('offboardConstant.termination_status'),
            'termination_status' => TerminationStatus::TERMINATE->value,
            'terminationTypes' => TerminationType::branchId()->get(['id', 'title'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Offboard/DisciplinaryActions/Create',[
            'datas' => $this->getData(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DisciplinaryAction\DisciplinaryActionRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DisciplinaryActionRequest $request)
    {
        if($request->action_type == 1)
        {
            $suspension = 1;
        	$penalty = 0;
        }else{
            $suspension = 0;
        	$penalty = 1;
        }
        DisciplinaryAction::create($request->validated() + [
            'suspension' => $suspension,
            'penalty' => $penalty,
        ]);
        return redirect()->route('admin.disciplinaryactions.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DisciplinaryAction  $disciplinaryaction
     * @return \Illuminate\Http\Response
     */
    public function show(DisciplinaryAction $disciplinaryaction)
    {
        $disciplinaryaction->load(['branch:id,name','user:id,name','isseudby:id,name', 'grounds:id,title']);
        return Inertia::render('Admin/Offboard/DisciplinaryActions/Show', [
            'disciplinaryaction' => $disciplinaryaction,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DisciplinaryActionRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DisciplinaryAction  $disciplinaryaction
     * @return \Illuminate\Http\Response
     */
    public function edit(DisciplinaryAction $disciplinaryaction)
    {
        $disciplinaryaction->action_type = $disciplinaryaction->suspension == OffboardActionType::SUSPENSION->value ? OffboardActionType::SUSPENSION->value : OffboardActionType::PENALTY->value;
        return Inertia::render('Admin/Offboard/DisciplinaryActions/Edit', [
            'disciplinaryaction' => $disciplinaryaction,
            'datas' => $this->getData(),
        ]);
    }

    public function update(DisciplinaryActionRequest $request, DisciplinaryAction $disciplinaryaction)
    {
        if($request->action_type == 1)
        {
            $suspension = 1;
        	$penalty = 0;
        }else{
            $suspension = 0;
        	$penalty = 1;
        }
        $disciplinaryaction->update($request->validated() + [
            'suspension' => $suspension,
            'penalty' => $penalty,
        ]);
        return redirect()->route('admin.disciplinaryactions.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DisciplinaryAction  $disciplinaryaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(DisciplinaryAction $disciplinaryaction)
    {
        $disciplinaryaction->delete();
        return back()->with('success', 'Record Deleted');
    }
    // Add STaff Terminate bool in displinary action
    public function terminatestaff($id, Request $request)
    {
        $this->validate($request, [
            'termination_type' => 'required',
            'termination_detail' => 'required',
            'offBoarding_date' => 'required|date',
            'status' => 'required',
        ]);
        $disciplinaryaction = DisciplinaryAction::findOrFail($id);
        $disciplinaryaction->update(['termination' => 1]);
        TerminationStaff::updateOrCreate([
            'user_id' => $disciplinaryaction->user_id,
            'termination_type' => $request->termination_type,
            'offBoarding_date' => $request->offBoarding_date,
            'status' => $request->status
        ], [
            'branch_id' => $disciplinaryaction->branch_id,
            'user_id' => $disciplinaryaction->user_id,
            'termination_type' => $request->termination_type,
            'termination_detail' => $request->termination_detail,
            'offBoarding_date' => $request->offBoarding_date,
            'status' => $request->status,
            'start_date' => $disciplinaryaction->issued_date,
            'end_date' => $disciplinaryaction->issued_date,
            'terminate_by' => auth()->id(),
            'justification_date' => $disciplinaryaction->justification_date,
            'justification_detail' => $disciplinaryaction->justification_detail,
        ]);
        return back()->with('success', 'Staff Terminated');
    }
    public function holdstaff($id)
    {
        $disciplinaryaction = DisciplinaryAction::findOrFail($id);
        $disciplinaryaction->update(['termination' => 2]);
        return back()->with('success', 'Staff Hold');
    }

    private function getData()
    {
        $data['staffs'] = User::active()->branchId()->get(['id', 'name']);
        $data['grounds'] = DisciplinaryGround::branchId()->orderBy('title')->get(['id', 'title']);
        $data['actions'] = config('offboardConstant.actions');
        $data['action_types'] = config('offboardConstant.action_types');
        $data['required'] = AppConstant::YN;
        return $data;
    }

    private function filterQuery($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }
        if(request()->filled('branch')) {
            $query->where('branch_id', request()->branch);
        }
        return $query;
    }

}

