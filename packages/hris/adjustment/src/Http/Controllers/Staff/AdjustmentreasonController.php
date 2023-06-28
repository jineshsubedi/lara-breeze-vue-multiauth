<?php

namespace Hris\Adjustment\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Hris\Adjustment\Models\Adjustmentreason;
use Hris\Adjustment\Requests\AdjustmentreasonRequest;
use Inertia\Inertia;

class AdjustmentreasonController extends Controller
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
        $query = Adjustmentreason::query();
        $filter = $this->filterQuery($query);
        $adjustmentreasons = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Staff/Adjustmentreasons/Index', [
            'adjustmentreasons' => $adjustmentreasons,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Adjustmentreasons/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Adjustmentreason\AdjustmentreasonRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdjustmentreasonRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            Adjustmentreason::create($data);
        }
        return redirect()->route('staffs.adjustmentreasons.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adjustmentreason  $adjustmentreason
     * @return \Illuminate\Http\Response
     */
    public function show(Adjustmentreason $adjustmentreason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdjustmentreasonRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Adjustmentreason  $adjustmentreason
     * @return \Illuminate\Http\Response
     */
    public function edit(Adjustmentreason $adjustmentreason)
    {
        return Inertia::render('Staff/Adjustmentreasons/Edit', [
            'adjustmentreason' => $adjustmentreason
        ]);
    }

    public function update(AdjustmentreasonRequest $request, Adjustmentreason $adjustmentreason)
    {
        $adjustmentreason->update($request->validated());
        return redirect()->route('staffs.adjustmentreasons.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adjustmentreason  $adjustmentreason
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adjustmentreason $adjustmentreason)
    {
        $adjustmentreason->delete();
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

