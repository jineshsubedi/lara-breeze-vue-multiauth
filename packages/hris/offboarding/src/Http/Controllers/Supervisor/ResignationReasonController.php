<?php

namespace Hris\Offboarding\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Hris\Offboarding\Models\ResignationReason;
use Hris\Offboarding\Requests\ResignationReasonRequest;
use Inertia\Inertia;

class ResignationReasonController extends Controller
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
        $query = ResignationReason::query();
        $filter = $this->filterQuery($query);
        $resignationreasons = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Offboard/ResignationReasons/Index', [
            'resignationreasons' => $resignationreasons
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Offboard/ResignationReasons/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ResignationReason\ResignationReasonRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ResignationReasonRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'branch_id' => auth()->user()->branch_id,
                'title' => $st['title'],
            ];
            ResignationReason::create($data);
        }
        return redirect()->route('supervisor.resignationreasons.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResignationReason  $resignationreason
     * @return \Illuminate\Http\Response
     */
    public function show(ResignationReason $resignationreason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ResignationReasonRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResignationReason  $resignationreason
     * @return \Illuminate\Http\Response
     */
    public function edit(ResignationReason $resignationreason)
    {
        return Inertia::render('Supervisor/Offboard/ResignationReasons/Edit', [
            'resignationreason' => $resignationreason
        ]);
    }

    public function update(ResignationReasonRequest $request, ResignationReason $resignationreason)
    {
        $resignationreason->update($request->validated());
        return redirect()->route('supervisor.resignationreasons.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResignationReason  $resignationreason
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResignationReason $resignationreason)
    {
        $resignationreason->delete();
        return back()->with('success', 'Record Deleted');
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

