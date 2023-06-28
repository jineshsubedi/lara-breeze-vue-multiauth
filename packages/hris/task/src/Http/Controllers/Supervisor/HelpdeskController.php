<?php

namespace Hris\Task\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Hris\Task\Models\HelpDesk;
use Hris\Task\Requests\HelpDeskRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = HelpDesk::with(['kra:id,title', 'fromUser:id,name', 'toUser:id,name']);
        $filter = $this->filterQuery($query);
        $tasks = $filter->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $data = $this->getData();
        $staffs = User::active()->userList()->get(['id', 'name']);
        return Inertia::render('Supervisor/Helpdesk/Index', [
            'tasks' => fn () => $tasks, // required for partial reload
            'data' => fn () => $data,
            'staffs' => fn () => $staffs,
            'filters' => $request->only(['title', 'task_from', 'task_to', 'complete_status', 'finish_time', 'type'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->getData();
        return Inertia::render('Supervisor/Helpdesk/Create', [
            'data' => fn () => $data,
            'defBranch' => fn () => auth()->user()->branch_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HelpDeskRequest $request)
    {
        $data = $request->validated() + [
            'task_id' => 0,
            'job_id' => 0,
            'task_from' => $request->user()->id,
            'start_time' => Date('Y-m-d')
        ];
        HelpDesk::create($data);
        return redirect()->route('supervisor.helpdesks.index')->with('success', 'Help Desk Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HelpDesk $helpdesk)
    {
        $helpdesk->load(['kra:id,title', 'fromUser:id,name', 'toUser:id,name', 'branch:id,name']);
        return Inertia::render('Supervisor/Helpdesk/Show', [
            'task' => fn () => $helpdesk,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HelpDesk $helpdesk)
    {
        $data = $this->getData();
        $defBranch = Branch::where('id', User::findOrFail($helpdesk->task_to)->branch_id)->first()->id;
        return Inertia::render('Supervisor/Helpdesk/Edit', [
            'task' => fn () => $helpdesk,
            'data' => fn () => $data,
            'defBranch' => fn () => $defBranch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HelpDeskRequest $request, HelpDesk $helpdesk)
    {
        $helpdesk->update($request->validated());
        return redirect()->route('supervisor.helpdesks.index')->with('success', 'Help Desk Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelpDesk $helpdesk)
    {
        $helpdesk->delete();
        return redirect()->route('supervisor.helpdesks.index')->with('success', 'Help Desk Deleted Successfully');
    }

    private function getData()
    {
        $data['branches'] = Branch::branchList();
        $data['taskTypes'] = config('taskConstant.task_ownership');
        $data['priorities'] = config('taskConstant.task_priority');
        return $data;
    }

    private function filterQuery($query)
    {
        if(request()->filled('title')) {
            $query->where('title','like', '%'. request()->title.'%');
        }
        if(request()->filled('from')) {
            $query->where('task_from',request()->from);
        }
        if(request()->filled('to')) {
            $query->where('task_to',request()->to);
        }
        if(request()->filled('status')) {
            $query->where('complete_status', request()->status);
        }
        if(request()->filled('finish_time')) {
            $query->where('finish_time',request()->finish_time);
        }
        if(request()->filled('type')) {
            if(request()->type == 1) // for to do task
            {
                $query->where('task_to', auth()->id())->where('complete_status', '0');
            }
            else if(request()->type == 2) // for task assigned to me
            {
                $query->where('task_to', auth()->id());
            }
            else if(request()->type == 3) // for task given from me
            {
                $query->where('task_from', auth()->id());
            }
            else{
                $query->where('task_from', auth()->id())->orWhere('task_to', auth()->id());
            }
        }else{
            $query->where('task_from', auth()->id())->orWhere('task_to', auth()->id());
        }
        return $query;
    }

    public function acceptTask($id)
    {
        $task = HelpDesk::findOrFail($id);
        if($task->task_to != auth()->id())
        {
            return back()->with('warning', 'You cannot Accept Other\'s Help Desk');
        }
        $task->update(['accept_status' => '1']);
        return back()->with('success', 'Help Desk Accepted');
    }
    public function completeTask($id)
    {
        $task = HelpDesk::findOrFail($id);
        if($task->task_to != auth()->id())
        {
            return back()->with('warning', 'You cannot Accept Other\'s Help Desk');
        }
        $task->update(['complete_status' => '1']);
        return back()->with('success', 'Help Desk Completed');
    }
}
