<?php

namespace Hris\Offboarding\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Hris\Offboarding\Models\DisciplinaryGround;
use Hris\Offboarding\Requests\DisciplinaryGroundRequest;
use Inertia\Inertia;

class DisciplinaryGroundController extends Controller
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
        $query = DisciplinaryGround::query();
        $filter = $this->filterQuery($query);
        $disciplinarygrounds = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Offboard/DisciplinaryGrounds/Index', [
            'disciplinarygrounds' => $disciplinarygrounds
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Offboard/DisciplinaryGrounds/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DisciplinaryGround\DisciplinaryGroundRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DisciplinaryGroundRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'branch_id' => auth()->user()->branch_id,
                'title' => $st['title'],
            ];
            DisciplinaryGround::create($data);
        }
        return redirect()->route('supervisor.disciplinarygrounds.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DisciplinaryGround  $disciplinaryground
     * @return \Illuminate\Http\Response
     */
    public function show(DisciplinaryGround $disciplinaryground)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DisciplinaryGroundRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DisciplinaryGround  $disciplinaryground
     * @return \Illuminate\Http\Response
     */
    public function edit(DisciplinaryGround $disciplinaryground)
    {
        return Inertia::render('Supervisor/Offboard/DisciplinaryGrounds/Edit', [
            'disciplinaryground' => $disciplinaryground
        ]);
    }

    public function update(DisciplinaryGroundRequest $request, DisciplinaryGround $disciplinaryground)
    {
        $disciplinaryground->update($request->validated());
        return redirect()->route('supervisor.disciplinarygrounds.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DisciplinaryGround  $disciplinaryground
     * @return \Illuminate\Http\Response
     */
    public function destroy(DisciplinaryGround $disciplinaryground)
    {
        $disciplinaryground->delete();
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

