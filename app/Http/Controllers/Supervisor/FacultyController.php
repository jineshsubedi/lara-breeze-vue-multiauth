<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Requests\Admin\FacultyRequest;
use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Faculty::query();
        $query->with(['education:id,title']);
        $filter = $this->filterQuery($query);
        $faculties = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Faculties/Index', [
            'faculties' => $faculties,
            'educations' => Education::orderBy('title')->get(['id', 'title']),
            'filters' => $request->only(['education', 'title'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Faculties/Create',[
            'educations' => Education::orderBy('title')->get(['id', 'title']),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Faculty\FacultyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FacultyRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'education_id' => $request->education_id,
                'title' => $st['title'],
            ];
            Faculty::create($data);
        }
        Faculty::create($request->validated());
        return redirect()->route('supervisor.faculties.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FacultyRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        return Inertia::render('Supervisor/Faculties/Edit', [
            'faculty' => $faculty,
            'educations' => Education::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function update(FacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->validated());
        return redirect()->route('supervisor.faculties.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
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
        if(request()->filled('education')) {
            $query->where('education_id', request()->education);
        }
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        return $query;
    }

}

