<?php

namespace Hris\Revenue\Http\Controllers\Supervisor;

use Hris\Revenue\Requests\DivisionRequest;
use App\Http\Controllers\Controller;
use Hris\Revenue\Models\Division;
use Inertia\Inertia;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Division::query();
        $filter = $this->filterQuery($query);
        $divisions = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Divisions/Index', [
            'divisions' => $divisions
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Divisions/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Division\DivisionRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DivisionRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            Division::create($data);
        }
        return redirect()->route('supervisor.divisions.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DivisionRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        return Inertia::render('Supervisor/Divisions/Edit', [
            'division' => $division
        ]);
    }

    public function update(DivisionRequest $request, Division $division)
    {
        $division->update($request->validated());
        return redirect()->route('supervisor.divisions.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        $division->delete();
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

