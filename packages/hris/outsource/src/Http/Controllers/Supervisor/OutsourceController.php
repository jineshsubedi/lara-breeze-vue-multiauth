<?php

namespace Hris\Outsource\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hris\Outsource\Enums\OutSourceStatus;
use Hris\Outsource\Exports\OutsourceProjectExport;
use Hris\Outsource\Models\Outsource;
use Hris\Outsource\Models\OutsourceStaffs;
use Hris\Outsource\Requests\OutsourceRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OutsourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Outsource::query();
        $query->with(['manager_person:id,name', 'supervisor_person:id,name']);
        $filter = $this->filterQuery($query);
        $outsources = $filter->latest('id', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        $outsources->map(function ($outsource) {
            $q = OutsourceStaffs::where('outsource_id', $outsource->id)->get();
            $outsource->active_staff = $q->where('status', OutSourceStatus::ACTIVE->value)->count();
            $outsource->resigned_staff = $q->where('status', OutSourceStatus::COMPLETED->value)->count();
            $outsource->abscond_staff = $q->where('status', OutSourceStatus::HOLD->value)->count();
            $outsource->terminated_staff = $q->where('status', OutSourceStatus::TERMINATE->value)->count();
            return $outsource;
        });
        $datas['status'] = config('outsourceConstant.status');
        $datas['excel'] = Storage::exists('export/'.auth()->id().'/project.xlsx') ? Storage::url('export/'.auth()->id().'/project.xlsx'): '';
        return Inertia::render('Supervisor/Outsources/Index', [
            'outsources' => $outsources,
            'datas' => $datas,
            'filters' => request()->only(['project', 'client', 'from', 'to', 'status'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Outsources/Create',[
            'datas' => $this->getData()
        ]);
    }

    private function getData()
    {
        $data['status'] = config('outsourceConstant.status');
        $data['staffs'] = User::active()->branchId()->get(['id', 'name']);

        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Outsource\OutsourceRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OutsourceRequest $request)
    {
        Outsource::create($request->validated());
        return redirect()->route('supervisor.outsources.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outsource  $outsource
     * @return \Illuminate\Http\Response
     */
    public function show(Outsource $outsource)
    {
        $outsource->load(['manager_person:id,name', 'supervisor_person:id,name']);
        return Inertia::render('Supervisor/Outsources/Show', [
            'outsource' => $outsource
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OutsourceRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Outsource  $outsource
     * @return \Illuminate\Http\Response
     */
    public function edit(Outsource $outsource)
    {
        return Inertia::render('Supervisor/Outsources/Edit', [
            'outsource' => $outsource,
            'datas' => $this->getData()
        ]);
    }

    public function update(OutsourceRequest $request, Outsource $outsource)
    {
        $outsource->update($request->validated());
        return redirect()->route('supervisor.outsources.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outsource  $outsource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outsource $outsource)
    {
        $outsource->delete();
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
        if(request()->filled('project')) {
            $query->where('project_name', 'LIKE', '%'.request()->project.'%');
        }
        if(request()->filled('client')) {
            $query->where('client_name', 'LIKE', '%'.request()->client.'%');
        }
        if(request()->filled('from')) {
            $query->where('contract_start','<=', request()->from);
        }
        if(request()->filled('to')) {
            $query->where('contract_end','>=', request()->to);
        }
        if(request()->filled('status')) {
            $query->where('status', request()->status);
        }
        return $query;
    }

    public function export()
    {
        $query = Outsource::query();
        $query->with(['manager_person:id,name', 'supervisor_person:id,name']);
        $filter = $this->filterQuery($query);
        $outsources = $filter->latest('id', 'desc')
            ->get()
            ->map(function ($outsource) {
                $q = OutsourceStaffs::where('outsource_id', $outsource->id)->get();
                $outsource->active_staff = $q->where('status', OutSourceStatus::ACTIVE->value)->count();
                $outsource->resigned_staff = $q->where('status', OutSourceStatus::COMPLETED->value)->count();
                $outsource->abscond_staff = $q->where('status', OutSourceStatus::HOLD->value)->count();
                $outsource->terminated_staff = $q->where('status', OutSourceStatus::TERMINATE->value)->count();
                return $outsource;
            });
        $datas['outsources'] = $outsources;
        (new OutsourceProjectExport($datas))->store('export/'.auth()->id().'/project.xlsx', 'public');
    }

}

