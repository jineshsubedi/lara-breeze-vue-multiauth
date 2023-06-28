<?php

namespace Hris\Hrletter\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Hris\Hrletter\Models\LetterType;
use Hris\Hrletter\Requests\LetterTypeRequest;
use Inertia\Inertia;

class LetterTypeController extends Controller
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
        $query = LetterType::query();
        $filter = $this->filterQuery($query);
        $lettertypes = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/LetterTypes/Index', [
            'lettertypes' => $lettertypes
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/LetterTypes/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LetterType\LetterTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LetterTypeRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            LetterType::create($data);
        }
        return redirect()->route('supervisor.lettertypes.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LetterType  $lettertype
     * @return \Illuminate\Http\Response
     */
    public function show(LetterType $lettertype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LetterTypeRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LetterType  $lettertype
     * @return \Illuminate\Http\Response
     */
    public function edit(LetterType $lettertype)
    {
        return Inertia::render('Supervisor/LetterTypes/Edit', [
            'lettertype' => $lettertype
        ]);
    }

    public function update(LetterTypeRequest $request, LetterType $lettertype)
    {
        $lettertype->update($request->validated());
        return redirect()->route('supervisor.lettertypes.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LetterType  $lettertype
     * @return \Illuminate\Http\Response
     */
    public function destroy(LetterType $lettertype)
    {
        $lettertype->delete();
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

