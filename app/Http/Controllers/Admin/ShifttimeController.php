<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShifttimeRequest;
use App\Models\Branch;
use App\Models\ShiftTime;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShifttimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::branchList();
        $query = ShiftTime::query();
        $query->with(['branch:id,name']);
        $filter = $this->filterQuery($query);
        $shifts = $filter->latest('id')->paginate(15);
        return Inertia::render('Admin/Shifttime/Index', [
            'shifts' => $shifts,
            'branches' => $branches,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::branchList();
        return Inertia::render('Admin/Shifttime/Create',[
            'branches' => $branches
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShifttimeRequest $request)
    {
        foreach($request->shift_time as $st)
        {
            $data = [
                'branch_id' => $request->branch_id,
                'title' => $st['title'],
                'start_time' => $st['start_time'],
                'end_time' => $st['end_time'],
            ];
            ShiftTime::create($data);
        }
        return redirect()->route('admin.shift_times.index')->with('success', 'Shift Time Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShiftTime $shiftTime)
    {
        return Inertia::render('Admin/Shifttime/Edit', [
            'shiftTime' => $shiftTime
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShifttimeRequest $request, ShiftTime $shiftTime)
    {
        $shiftTime->update($request->validated());
        return redirect()->route('admin.shift_times.index')->with('success', 'Shift Time Added Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShiftTime $shiftTime)
    {
        $shiftTime->delete();
        return back()->with('success', 'Shift Time Deleted Successfully!');
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
