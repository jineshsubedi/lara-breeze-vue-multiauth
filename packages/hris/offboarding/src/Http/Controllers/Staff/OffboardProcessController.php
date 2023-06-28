<?php

namespace Hris\Offboarding\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Hris\Offboarding\Models\OffboardProcess;
use Hris\Offboarding\Requests\OffboardProcessRequest;
use Inertia\Inertia;

class OffboardProcessController extends Controller
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
        $query = OffboardProcess::query();
        $query->with(['department']);
        $filter = $this->filterQuery($query);
        $offboardprocesses = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Staff/Offboard/Process/Index', [
            'offboardprocesses' => $offboardprocesses
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Offboard/Process/Create',[
            'departments' => Department::where('branch_id', auth()->user()->branch_id)->get(['id','title'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OffboardProcess\OffboardProcessRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OffboardProcessRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'branch_id' => auth()->user()->branch_id,
                'department_id' => $request->department_id,
                'title' => $st['title'],
            ];
            OffboardProcess::create($data);
        }
        return redirect()->route('staffs.offboardprocesses.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OffboardProcess  $offboardprocess
     * @return \Illuminate\Http\Response
     */
    public function show(OffboardProcess $offboardprocess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OffboardProcessRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OffboardProcess  $offboardprocess
     * @return \Illuminate\Http\Response
     */
    public function edit(OffboardProcess $offboardprocess)
    {
        return Inertia::render('Staff/Offboard/Process/Edit', [
            'offboardprocess' => $offboardprocess
        ]);
    }

    public function update(OffboardProcessRequest $request, OffboardProcess $offboardprocess)
    {
        $offboardprocess->update($request->validated());
        return redirect()->route('staffs.offboardprocesses.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OffboardProcess  $offboardprocess
     * @return \Illuminate\Http\Response
     */
    public function destroy(OffboardProcess $offboardprocess)
    {
        $offboardprocess->delete();
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

