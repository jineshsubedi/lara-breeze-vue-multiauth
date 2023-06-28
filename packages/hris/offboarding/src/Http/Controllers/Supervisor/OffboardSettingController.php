<?php

namespace Hris\Offboarding\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Hris\Offboarding\Models\OffboardSetting;
use Hris\Offboarding\Requests\OffboardSettingRequest;
use Inertia\Inertia;

class OffboardSettingController extends Controller
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
        $query = OffboardSetting::query();
        $query->with(['branch:id,name']);
        $filter = $this->filterQuery($query);
        $offboardsettings = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Offboard/Setting/Index', [
            'offboardsettings' => $offboardsettings
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Offboard/Setting/Create', [
            'branches' => Branch::branchList()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OffboardSetting\OffboardSettingRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OffboardSettingRequest $request)
    {
        OffboardSetting::create($request->validated());
        return redirect()->route('supervisor.offboardsettings.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OffboardSetting  $offboardsetting
     * @return \Illuminate\Http\Response
     */
    public function show(OffboardSetting $offboardsetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OffboardSettingRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OffboardSetting  $offboardsetting
     * @return \Illuminate\Http\Response
     */
    public function edit(OffboardSetting $offboardsetting)
    {
        return Inertia::render('Supervisor/Offboard/Setting/Edit', [
            'offboardsetting' => $offboardsetting
        ]);
    }

    public function update(OffboardSettingRequest $request, OffboardSetting $offboardsetting)
    {
        $offboardsetting->update($request->validated());
        return redirect()->route('supervisor.offboardsettings.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OffboardSetting  $offboardsetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(OffboardSetting $offboardsetting)
    {
        $offboardsetting->delete();
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

