<?php

namespace Hris\Travel\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Hris\Travel\Models\AssignmentCategory;
use Hris\Travel\Requests\AssignmentCategoryRequest;
use Inertia\Inertia;

class AssignmentCategoryController extends Controller
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
        $query = AssignmentCategory::query();
        $filter = $this->filterQuery($query);
        $assignmentcategories = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Staff/Travel/AssignmentCategories/Index', [
            'assignmentcategories' => $assignmentcategories
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Travel/AssignmentCategories/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentCategory\AssignmentCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentCategoryRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            AssignmentCategory::create($data);
        }
        return redirect()->route('staffs.assignmentcategories.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignmentCategory  $assignmentcategory
     * @return \Illuminate\Http\Response
     */
    public function show(AssignmentCategory $assignmentcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssignmentCategory  $assignmentcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignmentCategory $assignmentcategory)
    {
        return Inertia::render('Staff/Travel/AssignmentCategories/Edit', [
            'assignmentcategory' => $assignmentcategory
        ]);
    }

    public function update(AssignmentCategoryRequest $request, AssignmentCategory $assignmentcategory)
    {
        $assignmentcategory->update($request->validated());
        return redirect()->route('staffs.assignmentcategories.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentCategory  $assignmentcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignmentCategory $assignmentcategory)
    {
        $assignmentcategory->delete();
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

