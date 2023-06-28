<?php

namespace Hris\Travel\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Hris\Travel\Models\AssignmentType;
use Hris\Travel\Requests\AssignmentTypeRequest;
use Inertia\Inertia;

class AssignmentTypeController extends Controller
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
        $query = AssignmentType::query();
        $filter = $this->filterQuery($query);
        $assignmenttypes = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Travel/AssignmentTypes/Index', [
            'assignmenttypes' => $assignmenttypes
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Travel/AssignmentTypes/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentType\AssignmentTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentTypeRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            AssignmentType::create($data);
        }
        return redirect()->route('supervisor.assignmenttypes.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignmentType  $assignmenttype
     * @return \Illuminate\Http\Response
     */
    public function show(AssignmentType $assignmenttype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssignmentType  $assignmenttype
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignmentType $assignmenttype)
    {
        return Inertia::render('Supervisor/Travel/AssignmentTypes/Edit', [
            'assignmenttype' => $assignmenttype
        ]);
    }

    public function update(AssignmentTypeRequest $request, AssignmentType $assignmenttype)
    {
        $assignmenttype->update($request->validated());
        return redirect()->route('supervisor.assignmenttypes.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentType  $assignmenttype
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignmentType $assignmenttype)
    {
        $assignmenttype->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        // if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        // {
        //     $query->where('branch_id', auth()->user()->branch_id);
        // }else{
        //     if(request()->filled('branch')) {
        //         $query->where('branch_id', request()->branch);
        //     }
        // }
        return $query;
    }

}

