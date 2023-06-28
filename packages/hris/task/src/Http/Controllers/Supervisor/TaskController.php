<?php

namespace Hris\Task\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Hris\Task\Models\Task;
use Hris\Task\Models\TaskJob;
use Hris\Task\Requests\TaskJobRequest;
use Hris\Task\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected $disk = 'public';
    protected $path = 'tasks/jobs';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Task::with(['kra:id,title', 'fromUser:id,name', 'toUser:id,name', 'jobs:id,task_id,title'])->withCount('jobs');
        $filter = $this->filterQuery($query);
        $tasks = $filter->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $data = $this->getData();
        $staffs = User::active()->userList()->subordinate()->get(['id', 'name']);
        return Inertia::render('Supervisor/Tasks/Index', [
            'tasks' => fn () => $tasks,
            'data' => fn () => $data,
            'staffs' => fn () => $staffs,
            'filters' => $request->only(['title', 'task_from', 'task_to', 'complete_status', 'finish_time', 'project', 'type'])
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
        return Inertia::render('Supervisor/Tasks/Create', [
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
    public function store(TaskRequest $request)
    {
        $data = $request->validated() + [
            'parent_id' => 0,
            'parent_type' => 0,
            'task_from' => $request->user()->id,
            'start_time' => Date('Y-m-d')
        ];
        Task::create($data);
        return redirect()->route('supervisor.tasks.index')->with('success', 'Task Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $task->load(['kra:id,title', 'fromUser:id,name', 'toUser:id,name', 'jobs'])->loadCount('jobs');
        $data['priorities'] = config('taskConstant.task_priority');
        return Inertia::render('Supervisor/Tasks/Show', [
            'task' => fn () => $task,
            'data' => fn () => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $task->old_priority = $task->getRawOriginal('priority');
        $data = $this->getData();
        $defBranch = Branch::where('id', User::findOrFail($task->task_to)->branch_id)->first()->id;
        return Inertia::render('Supervisor/Tasks/Edit', [
            'task' => fn () => $task,
            'data' => fn () => $data,
            'defBranch' => $defBranch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return redirect()->route('supervisor.tasks.index')->with('success', 'Task Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('supervisor.tasks.index')->with('success', 'Task Deleted Successfully');
    }

    private function filterQuery($query)
    {
        if(request()->filled('title')) {
            $query->where('title','like', '%'. request()->title.'%');
        }
        if(request()->filled('project')) {
            $query->where('project','like', '%'. request()->project.'%');
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

    private function getData()
    {
        $data['branches'] = Branch::branchList();
        $data['parentTypes'] = config('taskConstant.parent_type');
        $data['taskTypes'] = config('taskConstant.task_ownership');
        $data['completeStatus'] = config('taskConstant.task_status');
        $data['priorities'] = config('taskConstant.task_priority');

        return $data;
    }

    public function saveJobs(TaskJobRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $document_path = '';
        if($request->hasFile('imageFile'))
        {
            $document_path = $request->file('imageFile')->store($this->path, $this->disk);
        }
        TaskJob::create($request->validated() + [
            'image' => $document_path,
            'task_id' => $task->id,
            'start_date' => Date('Y-m-d')
        ]); 
        return back()->with('success', 'Task Job Added Successfully!');
    }
    public function deleteJobs($id)
    {
        $job = TaskJob::findOrFail($id);
        if($job->image != '' && Storage::exists($job->getRawOriginal('image')))
        {
            Storage::delete($job->getRawOriginal('image'));
        }
        $job->delete();
        return back()->with('success', 'Task Job Deleted Successfully!');
    }

    public function acceptTask($id)
    {
        $task = Task::findOrFail($id);
        if($task->task_to != auth()->id())
        {
            return back()->with('warning', 'You cannot Accept Other\'s Task');
        }
        $task->update(['accept_date' => Date('Y-m-d')]);
        return back()->with('success', 'Task Accepted');
    }
    public function acceptTaskJob($id)
    {
        $task = TaskJob::findOrFail($id);
        $task->update(['complete_status' => '1']);
        return back()->with('success', 'Task Job Completed');
    }
    public function completeMyTask(Request $request, $id)
    {
        $this->validate($request, [
            'self_mark' => 'required|integer',
            'remarks' => 'required|string|max:500'
        ]);
        $task = Task::with(['jobs'])->findOrFail($id);
        if($task->task_to != auth()->id())
        {
            return back()->with('warning', 'You cannot complete this task');
        }
        $jobs = TaskJob::where('task_id', $task->id)->where('complete_status', '0')->count();
        if($jobs > 0)
        {
            return back()->with('warning', 'Please complete all the related job in this task');
        }
        $task->update([
            'complete_date' => Date('Y-m-d'),
            'self_mark' => $request->self_mark,
            'remarks' => $request->remarks,
        ]);
        return back()->with('success', 'Task Complete');
    }
    public function completeTask(Request $request, $id)
    {
        $this->validate($request, [
            'supervisor_mark' => 'required|integer',
            's_remarks' => 'required|string|max:500'
        ]);
        $task = Task::findOrFail($id);
        if($task->task_from != auth()->id())
        {
            return back()->with('warning', 'You cannot complete this task');
        }
        $task->update([
            'complete_status' => '1',
            'supervisor_mark' => $request->supervisor_mark,
            's_remarks' => $request->s_remarks,
        ]);
        return back()->with('success', 'Task Complete');
    }
}
