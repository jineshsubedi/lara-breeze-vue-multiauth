<?php

namespace Hris\Task\Http\Controllers\Admin;

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
        $staffs = User::active()->userList()->get(['id', 'name']);
        return Inertia::render('Admin/Tasks/Index', [
            'tasks' => $tasks,
            'data' => $data,
            'staffs' => $staffs,
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
        return Inertia::render('Admin/Tasks/Create', [
            'data' => $data,
            'defBranch' => auth()->user()->branch_id,
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
        return redirect()->route('admin.tasks.index')->with('success', 'Task Created Successfully!');
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
        return Inertia::render('Admin/Tasks/Show', [
            'task' => $task,
            'data' => $data
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
        $data = $this->getData();
        $defBranch = Branch::where('id', User::findOrFail($task->task_to)->branch_id)->first()->id;
        return Inertia::render('Admin/Tasks/Edit', [
            'task' => $task,
            'data' => $data,
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
        return redirect()->route('admin.tasks.index')->with('success', 'Task Updated Successfully!');
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
        return redirect()->route('admin.tasks.index')->with('success', 'Task Deleted Successfully');
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
                $query->where('task_to', auth()->id())->where('complete_status', 0);
            }
            if(request()->type == 2) // for task assigned to me
            {
                $query->where('task_to', auth()->id());
            }
            if(request()->type == 3) // for task given from me
            {
                $query->where('task_from', auth()->id());
            }
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
}
