<?php

namespace Hris\Offboarding\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Offboarding\Models\TerminationType;
use Hris\Offboarding\Requests\TerminationTypeRequest;
use Inertia\Inertia;

class TerminationTypeController extends Controller
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
        $query = TerminationType::query();
        $filter = $this->filterQuery($query);
        $terminationtypes = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/Offboard/TerminationTypes/Index', [
            'terminationtypes' => $terminationtypes
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Offboard/TerminationTypes/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TerminationType\TerminationTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TerminationTypeRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'branch_id' => auth()->user()->branch_id,
                'title' => $st['title'],
            ];
            TerminationType::create($data);
        }
        return redirect()->route('admin.terminationtypes.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TerminationType  $terminationtype
     * @return \Illuminate\Http\Response
     */
    public function show(TerminationType $terminationtype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TerminationTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TerminationType  $terminationtype
     * @return \Illuminate\Http\Response
     */
    public function edit(TerminationType $terminationtype)
    {
        return Inertia::render('Admin/Offboard/TerminationTypes/Edit', [
            'terminationtype' => $terminationtype
        ]);
    }

    public function update(TerminationTypeRequest $request, TerminationType $terminationtype)
    {
        $terminationtype->update($request->validated());
        return redirect()->route('admin.terminationtypes.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TerminationType  $terminationtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(TerminationType $terminationtype)
    {
        $terminationtype->delete();
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

