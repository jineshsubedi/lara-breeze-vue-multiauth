<?php

namespace Hris\Subordinate\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Hris\Subordinate\Models\Subordinate;
use Hris\Subordinate\Requests\SubordinateRequest;
use Inertia\Inertia;

class SubordinateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Subordinate::query();
        $query->with(['user:id,name']);
        $filter = $this->filterQuery($query);
        $subordinates = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Subordinates/Index', [
            'subordinates' => $subordinates,
            'filters' => request()->only(['type'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Subordinates/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Subordinate\SubordinateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubordinateRequest $request)
    {
        if(auth()->user()->supervisor_id == 0 )
            return back()->with('warning', 'You Have No Supervisor to Comment');
        Subordinate::create($request->validated());
        return redirect()->route('supervisor.subordinates.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subordinate  $subordinate
     * @return \Illuminate\Http\Response
     */
    public function show(Subordinate $subordinate)
    {
        $subordinate->load(['user:id,name', 'supervisor:id,name']);
        return Inertia::render('Supervisor/Subordinates/Show', [
            'subordinate' => $subordinate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubordinateRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subordinate  $subordinate
     * @return \Illuminate\Http\Response
     */
    public function edit(Subordinate $subordinate)
    {
        return Inertia::render('Supervisor/Subordinates/Edit', [
            'subordinate' => $subordinate
        ]);
    }

    public function update(SubordinateRequest $request, Subordinate $subordinate)
    {
        $subordinate->update($request->validated());
        return redirect()->route('supervisor.subordinates.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subordinate  $subordinate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subordinate $subordinate)
    {
        $subordinate->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        $query->where('branch_id', auth()->user()->branch_id);
        if(request()->filled('type')) {
            if(request()->type == 'others')
            {
                $query->where('supervisor', auth()->id());
            }else{
                $query->where('user_id', auth()->id());
            }
        }else{
            $query->where('user_id', auth()->id());
        }
        return $query;
    }

}

