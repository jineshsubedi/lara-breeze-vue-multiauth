<?php

namespace Hris\Offboarding\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hris\Offboarding\Enums\TerminationStatus;
use Hris\Offboarding\Models\TerminationStaff;
use Hris\Offboarding\Models\TerminationType;
use Hris\Offboarding\Requests\TerminateStaffRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TerminateStaffController extends Controller
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
        $query = TerminationStaff::query();
        $query->with(['user:id,name', 'type:id,title']);
        $filter = $this->filterQuery($query);
        $terminationstaffs = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Offboard/TerminationStaffs/Index', [
            'terminationstaffs' => $terminationstaffs,
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
        return Inertia::render('Supervisor/Offboard/TerminationStaffs/Create', [
            'datas' => $this->getData()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerminateStaffRequest $request)
    {
        TerminationStaff::create($request->validated());
        return redirect()->route('supervisor.terminatestaffs.index')->with('success', 'Record Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $terminationstaff = TerminationStaff::findOrFail($id);
        $terminationstaff->load(['user:id,name', 'type:id,title', 'terminteby:id,name']);
        return Inertia::render('Supervisor/Offboard/TerminationStaffs/Show', [
            'terminationstaff' => $terminationstaff,
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
        $terminationstaff = TerminationStaff::findOrFail($id);
        $terminationstaff->load(['user:id,name', 'type:id,title']);
        return Inertia::render('Supervisor/Offboard/TerminationStaffs/Edit', [
            'terminationstaff' => $terminationstaff,
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
    public function update(TerminateStaffRequest $request, $id)
    {
        $terminationstaff = TerminationStaff::findOrFail($id);
        $terminationstaff->update($request->validated());
        return redirect()->route('supervisor.terminatestaffs.index')->with('success', 'Record Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $terminationstaff = TerminationStaff::findOrFail($id);
        $terminationstaff->delete();
        return redirect()->route('supervisor.terminatestaffs.index')->with('success', 'Record Deleted!');
    }

    private function getData()
    {
        $data['staffs'] = User::active()->branchId()->get(['id', 'name']);
        $data['types'] = TerminationType::branchId()->get(['id', 'title']);
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
