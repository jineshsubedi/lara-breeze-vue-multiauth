<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DesignationRequest;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DesignationController extends Controller
{
    protected $disk = 'public';
    protected $path = 'designation';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Designation::query();
        $query->with(['department:id,title']);
        $filter = $this->filterQuery($query);
        $designations = $filter->latest('id')->paginate(15);
        return Inertia::render('Admin/Designation/Index', [
            'designations' => $designations,
            'filters' => $request->only(['title', 'department_id'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::branchList()->get(['id', 'title']);
        return Inertia::render('Admin/Designation/Create', [
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignationRequest $request)
    {
        Designation::create($request->validated() + [
            'tor' => $request->file('document')->store($this->path, $this->disk)
        ]);
        return redirect()->route('admin.designations.index')->with('success', 'Designation Added Successfully!');
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
    public function edit(Designation $designation)
    {
        $departments = Department::branchList()->get(['id', 'title']);
        $tor_file = Storage::exists($designation->tor) ? Storage::url($designation->tor) : '';
        return Inertia::render('Admin/Designation/Edit', [
            'designation' => $designation,
            'departments' => $departments,
            'tor_file' => $tor_file
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DesignationRequest $request, Designation $designation)
    {
        $tor_path = $designation->tor;
        if($request->hasFile('document'))
        {
            $this->deleteFile($designation);
            $tor_path = $request->file('document')->store($this->path, $this->disk);
        }
        $designation->update($request->validated() + [
            'tor' => $tor_path
        ]);
        return redirect()->route('admin.designations.index')->with('success', 'Designation Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        $this->deleteFile($designation);
        $designation->delete();
        return back()->with('success', 'Designation Deleted Successfully');
    }
    public function deleteFile($designation)
    {
        if(Storage::exists($designation->tor))
        {
            Storage::delete($designation->tor);
        }
    }

    private function filterQuery($query)
    {
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $departmentIds = Department::where('branch_id', auth()->user()->branch_id)->pluck('id');
            $query->whereIn('department_id', $departmentIds);
        }
        return $query;
    }
}
