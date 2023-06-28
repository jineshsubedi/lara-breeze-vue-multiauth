<?php

namespace Hris\Interview\Http\Controllers\Supervisor;

use App\Enums\AppConstant;
use App\Enums\StaffType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hris\Interview\Models\ExitInterview;
use Hris\Interview\Requests\ExitInterviewRequest;
use Inertia\Inertia;

class ExitInterviewController extends Controller
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
        $query = ExitInterview::query();
        $query->with(['user:id,name', 'branch:id,name', 'received:id,name']);
        $filter = $this->filterQuery($query);
        $exitinterviews = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/ExitInterviews/Index', [
            'exitinterviews' => $exitinterviews
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/ExitInterviews/Create',[
            'descriptions' => AppConstant::EXIT_INTERVIEW_QUESTION,
            'staffs' => User::where('status', '!=', User::CURRENTLY_WORKING)->branchId()->get(['id', 'name']),
            'admins' => User::active()->branchId()->where('staff_type', StaffType::ADMIN->value)->get(['id', 'name'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExitInterview\ExitInterviewRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ExitInterviewRequest $request)
    {
        ExitInterview::create($request->validated());
        return redirect()->route('supervisor.exitinterviews.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExitInterview  $exitinterview
     * @return \Illuminate\Http\Response
     */
    public function show(ExitInterview $exitinterview)
    {
        $exitinterview->load(['user:id,name', 'branch:id,name', 'received:id,name']);
        return Inertia::render('Supervisor/ExitInterviews/Show',[
            'exitinterview' => $exitinterview
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExitInterviewRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExitInterview  $exitinterview
     * @return \Illuminate\Http\Response
     */
    public function edit(ExitInterview $exitinterview)
    {
        return Inertia::render('Supervisor/ExitInterviews/Edit', [
            'exitinterview' => $exitinterview
        ]);
    }

    public function update(ExitInterviewRequest $request, ExitInterview $exitinterview)
    {
        $exitinterview->update($request->validated());
        return redirect()->route('supervisor.exitinterviews.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExitInterview  $exitinterview
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExitInterview $exitinterview)
    {
        $exitinterview->delete();
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

