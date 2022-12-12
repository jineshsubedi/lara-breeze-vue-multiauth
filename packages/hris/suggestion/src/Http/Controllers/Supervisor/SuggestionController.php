<?php

namespace Hris\Suggestion\Http\Controllers\Supervisor;

use Hris\Suggestion\Requests\SuggestionRequest;
use Hris\Suggestion\Models\SuggestionReply;
use Hris\Suggestion\Models\SuggestionFor;
use Hris\Suggestion\Models\SuggestionBox;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\AppConstant;
use App\Enums\StaffType;
use App\Models\Branch;
use App\Models\User;
use Inertia\Inertia;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SuggestionBox::with(['branch:id,name', 'user:id,name', 'SuggestionFor:id,title'])->withCount('Suggestion_reply');
        $filter = $this->filterQuery($query);
        $suggestions = $filter->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $branches = Branch::branchList();
        $defBranch = auth()->user()->branch_id;
        if($request->branch)
            $defBranch = $request->branch;
        $staffs = User::active()->where('branch_id', $defBranch)->get(['id', 'name']);
        $categories = SuggestionFor::orderBy('title', 'asc')->get(['id', 'title']);
        return Inertia::render('Supervisor/Suggestion/Index', [
            'staffs' => $staffs,
            'branches' => $branches,
            'defBranch' => $defBranch,
            'categories' => $categories,
            'suggestions' => $suggestions,
            'filters' => $request->only(['staff', 'branch', 'category'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SuggestionFor::orderBy('title', 'asc')->get(['id', 'title']);
        $options = AppConstant::YN;
        return Inertia::render('Supervisor/Suggestion/Create', [
            'categories' => $categories,
            'options' => $options
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuggestionRequest $request)
    {
        SuggestionBox::create($request->validated() + [
            'branch_id' => auth()->user()->branch_id,
            'user_id' => auth()->id()
        ]);
        return redirect()->route('admin.suggestions.index')->with('Suggestion Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SuggestionBox $suggestion)
    {
        $suggestion->load(['branch:id,name', 'user:id,name', 'SuggestionFor:id,title', 'suggestion_reply' => function($query) {
            $query->with(['user:id,name']);
        }]);
        return Inertia::render('Supervisor/Suggestion/Show', [
            'suggestion' => $suggestion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuggestionRequest $request, SuggestionBox $suggestion)
    {
        SuggestionReply::create($request->validated() + [
            'suggestion_box_id' => $suggestion->id,
            'user_id' => auth()->id()
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuggestionBox $suggestion)
    {
        $suggestion->delete();
        return back()->with('success', 'Suggestion Deleted');
    }

    private function filterQuery($query)
    {
        if(request()->filled('category')) {
            $query->where('suggestion_for_id', request()->category);
        }
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
            if(auth()->user()->staff_type != StaffType::ADMIN->value && !auth()->user()->roles->where('name', 'HrHandler')->first())
            {
                $query->where('user_id', auth()->id());
            }
        }else{
            if(request()->filled('branch')) {
                $query->where('branch_id', request()->branch);
            }
        }
        if(request()->filled('staff')) {
            $query->where('user_id', request()->staff);
        }
        return $query;
    }
}
