<?php

namespace Hris\Attendance\Http\Controllers\Admin;

use App\Enums\AppConstant;
use Hris\Attendance\Requests\AttendanceRequest;
use Hris\Attendance\Models\Attendance;
use App\Http\Controllers\Controller;
use App\Library\NepaliDateApi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    use NepaliDateApi;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['user:id,name']);
        $filter = $this->filterQuery($query);
        $attendances = $filter->latest()->paginate(50)->withQueryString();
        $staffs = User::active()
                    ->branchId()
                    ->where(function ($q) {
                        $q->where('supervisor_id', auth()->id())
                            ->orWhere('id', auth()->id());
                    })
                    ->select('id', 'name')
                    ->get();
        // return $attendances;
        return Inertia::render('Admin/Attendance/Index', [
            'attendances' => $attendances,
            'staffs' => $staffs,
            'filters' => $request->only(['from', 'to', 'staff'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'location' => ['required','string'],
            'type' => ['required','string'],
        ]);
        $today = date('Y-m-d');
        $np_today = $this->eng_to_nep(Date('Y'), Date('m'), Date('d'));
        if ($request->type == 'clockin')
        {
            Attendance::create([
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'attendance_date' => $today,
                'in_time' => date('H:i:s'),
                'in_location' => $request->location,
                'np_year' => $np_today['year'],
                'np_month' => $np_today['month'],
                'np_date' => $np_today['date'],
                'approve' => '0'
            ]);
        }
        if ($request->type == 'lunchout')
        {
            $attendance = Attendance::where('user_id', auth()->user()->id)->where('attendance_date',$today)->orderBy('id','desc')->first();
            if (isset($attendance->id))
            {
                $attendance->update([
                    'lunch_start' => date('H:i:s'),
                    'lunch_start_location' => $request->location,
                ]);
            }

        }
        if ($request->type == 'lunchin')
        {
            $attendance = Attendance::where('user_id', auth()->user()->id)->where('attendance_date',$today)->orderBy('id','desc')->first();
            if (isset($attendance->id))
            {
                $attendance->update([
                    'lunch_end' => date('H:i:s'),
                    'lunch_end_location' => $request->location,
                ]);
            }
        }
        if ($request->type == 'clockout')
        {
            $attendance = Attendance::where('user_id', auth()->user()->id)->where('attendance_date',$today)->orderBy('id','desc')->first();
            if (isset($attendance->id))
            {
                $to1 = Carbon::parse($attendance->attendance_date . ' ' . $attendance->in_time);
                $to2 = Carbon::parse($attendance->attendance_date . ' ' . date('H:i:s'));
                $duration = $to2->diffInHours($to1);
                $attendance->update([
                    'out_time' => date('H:i:s'),
                    'out_location' => $request->location,
                    'approve' => $duration > AppConstant::WORKDURATION ? '1' : '0'
                ]);
            }else{
                Attendance::create([
                    'user_id' => auth()->user()->id,
                    'attendance_date' => date('Y-m-d'),
                    'out_time' => date('H:i:s'),
                    'out_location' => $request->location,
                    'np_year' => $np_today['year'],
                    'np_month' => $np_today['month'],
                    'np_date' => $np_today['date'],
                    'approve' => '0'
                ]);
            }

        }
        return back()->with('info', 'Thank you');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        $attendance->load(['user:id,name']);
        $data['late_clock_in'] = false;
        $data['away_clock_in'] = false;
        $data['away_clock_out'] = false;
        $data['early_clock_out'] = false;

        $shift = auth()->user()->shiftTime;
        if(isset($shift->id))
        {
            if($shift->start_time <= $attendance->in_time && $attendance->in_time_reason == null)
            {
                $data['late_clock_in'] = true;
            }
            if($attendance->out_time != null && $shift->end_time >= $attendance->out_time && $attendance->out_time_reason == null)
            {
                $data['early_clock_out'] = true;
            }
        }
        $data['away_clock_in'] = $attendance->in_time != null && $attendance->in_away_location == null ? $attendance->generateDistance($attendance->in_location) : false;
        $data['away_clock_out'] = $attendance->out_time != null && $attendance->out_away_location == null && $attendance->out_time_reason == null ? $attendance->generateDistance($attendance->out_location) : false;
        return Inertia::render('Admin/Attendance/Show', [
            'attendance' => $attendance,
            'data' => $data
        ]);
    }

    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->validated());
        return back()->with('success', 'Reason Saved!');
    }

    
    public function approve($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'approve' => '1'
        ]);
        return back()->with('info', 'Approved');
    }

    public function reject($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'approve' => '2'
        ]);
    }
    public function approveAll(Request $request)
    {
        $this->validate($request, [
            'attendance_ids.*' => 'required' 
        ]);
        if(isset($request->attendance_ids))
        {
            Attendance::whereIn('id', $request->attendance_ids)->update(['approve' => '1']);
        }
    }
    private function filterQuery($query)
    {
        if(request()->filled('staff')){
            $query->where('user_id', request()->staff);
        }else{
            $subOrdinateIds = User::where('supervisor_id', auth()->id())->pluck('id');
            $query->where(function ($q) use($subOrdinateIds){
                $q->whereIn('user_id', $subOrdinateIds)
                    ->orWhere('user_id', auth()->id());
            });
        }
        if(request()->filled('from')) {
            $query->whereDate('attendance_date','>=', request()->from);
        }
        if(request()->filled('to')) {
            $query->whereDate('attendance_date','<=', request()->to);
        }
        return $query;
    }
}
