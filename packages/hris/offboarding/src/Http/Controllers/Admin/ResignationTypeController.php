<?php

namespace Hris\Offboarding\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Offboarding\Models\ResignationType;
use Hris\Offboarding\Requests\ResignationTypeRequest;
use Inertia\Inertia;

class ResignationTypeController extends Controller
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
        $query = ResignationType::query();
        $filter = $this->filterQuery($query);
        $resignationtypes = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/Offboard/ResignationTypes/Index', [
            'resignationtypes' => $resignationtypes
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Offboard/ResignationTypes/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ResignationType\ResignationTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ResignationTypeRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'branch_id' => auth()->user()->branch_id,
                'title' => $st['title'],
                'description' => $st['description'],
            ];
            ResignationType::create($data);
        }
        return redirect()->route('admin.resignationtypes.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResignationType  $resignationtype
     * @return \Illuminate\Http\Response
     */
    public function show(ResignationType $resignationtype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ResignationTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResignationType  $resignationtype
     * @return \Illuminate\Http\Response
     */
    public function edit(ResignationType $resignationtype)
    {
        return Inertia::render('Admin/Offboard/ResignationTypes/Edit', [
            'resignationtype' => $resignationtype
        ]);
    }

    public function update(ResignationTypeRequest $request, ResignationType $resignationtype)
    {
        $resignationtype->update($request->validated());
        return redirect()->route('admin.resignationtypes.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResignationType  $resignationtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResignationType $resignationtype)
    {
        $resignationtype->delete();
        return back()->with('success', 'Record Deleted');
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

