<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\library\NepaliDateApi;
use Illuminate\Http\Request;
use App\Library\MyFunction;
use App\Models\DailyTask;
use App\Models\UserKra;
use Inertia\Inertia;
use App\Models\User;
use Carbon\Carbon;

class DailyTaskController extends Controller
{
    use NepaliDateApi;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userIds = User::active()->where('supervisor_id', auth()->id())->pluck('id');
        $query = DailyTask::with(['kra', 'user']);
        $filter = $this->filterQuery($query, $userIds);
        $dtasks = $filter->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $kras = UserKra::where('user_id', auth()->id())->get(['id', 'title']);
        $staffs = User::active()
                ->where('supervisor_id', auth()->id())
                ->orWhere('id', auth()->id())
                ->get(['id', 'name']);
        $aprovalCount = DailyTask::whereIn('user_id', $userIds)->where('status', '0')->count();

        return Inertia::render('Staff/DailyTasks/Index', [
            'dtasks' => $dtasks,
            'kras' => $kras,
            'staffs' => $staffs,
            'aprovalCount' => $aprovalCount,
            'filters' => $request->only(['work_date', 'staff', 'status', 'type'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'work_date' => ['required', 'date', 'before:tomorrow'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'kra' => ['sometimes'],
            'description' => ['required'],
        ])->validate();
        $endate = Carbon::parse($request->booking_date);
        $nep_date = $this->eng_to_nep($endate->year, $endate->month, $endate->day);
        $kra = 0;
        $task_id = 0;
        $type = '';
        if (isset($request->kra)) {
            $kra = $request->kra;
        }
        if (isset($request->task_id)) {
            $task_id = $request->task_id;
        }
        if (isset($request->type)) {
            $type = $request->type;
        }
        $duration = MyFunction::getDuration($request->start_time, $request->end_time);
        $data = [
            'user_id' => auth()->user()->id,
            'en_year' => $endate->year,
            'en_month' => $endate->month,
            'en_day' => $endate->day,
            'np_year' => $nep_date['year'],
            'np_month' => $nep_date['month'],
            'np_day' => $nep_date['date'],
            'start_time' => $request->work_date.' '.$request->start_time,
            'end_time' => $request->work_date.' '.$request->end_time,
            'description' => trim($request->description),
            'kra_id' => $kra,
            'task_id' => $task_id,
            'duration' => $duration,
        ];
        DailyTask::create($data);
        return back()->with('success', 'Your Task Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DailyTask $dailytask)
    {
        $dailytask->load(['kra:id,title', 'user:id,name']);
        return Inertia::render('Staff/DailyTasks/Show', [
            'dailytask' => $dailytask,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyTask $dailytask)
    {
        $dailytask->work_date = $dailytask->en_year.'-'.$dailytask->en_month.'-'.$dailytask->en_day;
        $dailytask->start_time = Carbon::parse($dailytask->start_time)->format('H:i:s');
        $dailytask->end_time = Carbon::parse($dailytask->end_time)->format('H:i:s');
        $dailytask->kra = $dailytask->kra_id;
        $kras = UserKra::where('user_id', auth()->id())->get(['id', 'title']);
        return Inertia::render('Staff/DailyTasks/Edit', [
            'dailytask' => $dailytask,
            'kras' => $kras
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyTask $dailytask)
    {
        $this->validate($request, [
            'work_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'required'
        ]);
        $endate = Carbon::parse($request->work_date);
        $nep_date = $this->eng_to_nep($endate->year, $endate->month, $endate->day);
        $kra = 0;
        $task_id = 0;
        $type = '';
        if (isset($request->kra)) {
            $kra = $request->kra;
        }
        if (isset($request->task_id)) {
            $task_id = $request->task_id;
        }
        $duration = MyFunction::getDuration($request->start_time, $request->end_time);
        $data = [
            'user_id' => auth()->user()->id,
            'en_year' => $endate->year,
            'en_month' => $endate->month,
            'en_day' => $endate->day,
            'np_year' => $nep_date['year'],
            'np_month' => $nep_date['month'],
            'np_day' => $nep_date['date'],
            'start_time' => $request->work_date.' '.$request->start_time,
            'end_time' => $request->work_date.' '.$request->end_time,
            'description' => trim($request->description),
            'kra_id' => $kra,
            'task_id' => $task_id,
            'duration' => $duration,
        ];
        $dailytask->update($data);
        return redirect()->route('staffs.dailytasks.index')->with('success', 'Daily Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyTask $dailytask)
    {
        $dailytask->delete();
        return back()->with('success', 'Daily Task Deleted Successfully');
    }

    public function approve(Request $request)
    {
        if (is_array($request->selected) && count($request->selected) > 0) {
            for ($i = 0; $i < count($request->selected); $i++) {
                $dtask = DailyTask::where('id', $request->selected[$i])
                ->where('user_id', '!=', auth()->id())->where('status', '0')->first();
                if(isset($dtask->id))
                    $dtask->update(['status' => '1', 'estimated_duration'=> $dtask->duration]);
            }
            return back()->with('info', 'Approved');
        }
    }

    public function approveById(Request $request, $id)
    {
        $this->validate($request, [
            'estimated_duration' => 'required'
        ]);
        $dtask = DailyTask::findOrFail($id);
        $dtask->update(['estimated_duration' => $request->estimated_duration, 'status' => '1']);
        return back()->with('success', 'Daily Task Approved');
    }

    private function filterQuery($query, $userIds)
    {
        
        if(request()->filled('type')) {
            if(request()->type == 1)
            {
                $query->where('user_id', auth()->id());
            }
            else if(request()->type == 2)
            {
                $query->whereIn('user_id', $userIds)->where('status', '0');
            }else{
                $query->whereIn('user_id', $userIds)->orWhere('user_id', auth()->id());
            }   
        }else if(request()->filled('staff')) {
            $query->where('user_id', request()->staff);
        }
        else{
            $query->whereIn('user_id', $userIds)->orWhere('user_id', auth()->id());
        }
        if(request()->filled('work_date')) {
            $query->whereDate('start_time', request()->work_date);
        }
        if(request()->filled('status')){
            if(request()->status != 'all')
            {
                $query->where('status', request()->status);
            }
        }
        return $query;
    }
}
