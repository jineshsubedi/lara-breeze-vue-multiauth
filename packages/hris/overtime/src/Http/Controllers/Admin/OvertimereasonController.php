<?php

namespace Hris\Overtime\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Overtime\Models\Overtimereason;
use Hris\Overtime\Requests\OvertimereasonRequest;
use Inertia\Inertia;

class OvertimereasonController extends Controller
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
        $query = Overtimereason::query();
        $filter = $this->filterQuery($query);
        $overtimereasons = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/Overtimereasons/Index', [
            'overtimereasons' => $overtimereasons,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Overtimereasons/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Overtimereason\OvertimereasonRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OvertimereasonRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            Overtimereason::create($data);
        }
        return redirect()->route('admin.overtimereasons.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtimereason  $overtimereason
     * @return \Illuminate\Http\Response
     */
    public function show(Overtimereason $overtimereason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OvertimereasonRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Overtimereason  $overtimereason
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtimereason $overtimereason)
    {
        return Inertia::render('Admin/Overtimereasons/Edit', [
            'overtimereason' => $overtimereason
        ]);
    }

    public function update(OvertimereasonRequest $request, Overtimereason $overtimereason)
    {
        $overtimereason->update($request->validated());
        return redirect()->route('admin.overtimereasons.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtimereason  $overtimereason
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtimereason $overtimereason)
    {
        $overtimereason->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        // if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        // {
        //     $query->where('branch_id', auth()->user()->branch_id);
        // }
        // if(request()->filled('branch')) {
        //     $query->where('branch_id', request()->branch);
        // }
        return $query;
    }

}

