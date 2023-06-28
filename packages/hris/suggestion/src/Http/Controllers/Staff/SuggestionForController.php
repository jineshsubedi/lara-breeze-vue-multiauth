<?php

namespace Hris\Suggestion\Http\Controllers\Staff;

use Hris\Suggestion\Requests\SuggestionForRequest;
use Hris\Suggestion\Models\SuggestionFor;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SuggestionForController extends Controller
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
        $categories = SuggestionFor::orderBy('title')->paginate(20)->withQueryString();
        return Inertia::render('Staff/Suggestionfor/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Suggestionfor/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuggestionForRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            SuggestionFor::create($data);
        }
        return redirect()->route('staffs.suggestionfor.index')->with('success', 'Suggestion Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SuggestionFor $suggestionfor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SuggestionFor $suggestionfor)
    {
        return Inertia::render('Staff/Suggestionfor/Edit', [
            'suggestionfor' => $suggestionfor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuggestionForRequest $request, SuggestionFor $suggestionfor)
    {
        $suggestionfor->update($request->validated());
        return redirect()->route('staffs.suggestionfor.index')->with('success', 'Suggetion Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuggestionFor $suggestionfor)
    {
        $suggestionfor->delete();
        return back()->with('success', 'Suggestion Category Deleted Successfully!');
    }
}
