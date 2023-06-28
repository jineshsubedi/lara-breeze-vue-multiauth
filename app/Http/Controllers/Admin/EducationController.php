<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\EducationRequest;
use App\Http\Controllers\Controller;
use App\Models\Education;
use Inertia\Inertia;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Education::query();
        $filter = $this->filterQuery($query);
        $education = $filter->orderBy('title', 'asc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/Education/Index', [
            'education' => $education
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Education/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Education\EducationRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EducationRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            Education::create($data);
        }
        return redirect()->route('admin.education.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EducationRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $education)
    {
        return Inertia::render('Admin/Education/Edit', [
            'education' => $education
        ]);
    }

    public function update(EducationRequest $request, Education $education)
    {
        $education->update($request->validated());
        return redirect()->route('admin.education.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $education)
    {
        $education->delete();
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

