<?php

namespace Hris\Attendance\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\NepaliDateApi;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Setting;
use Hris\Attendance\Models\Attendance;

class AttendanceController extends Controller
{
    use NepaliDateApi;

    public function index(Request $request)
    {
        $param = $request->fullUrlWithQuery(collect($request->query)->toArray());
        $subOrdinateIds = User::where('supervisor_id', auth()->id())->pluck('id');
        $query = Attendance::where('user_id', auth()->id());
        $query2 = Attendance::whereIn('user_id', $subOrdinateIds);

        $filter = $this->filterQuery($query, false);
        $filter2 = $this->filterQuery($query2, true);

        $attendances = $filter->latest('id')->paginate(50, ['*'], 'attendances')->appends(request()->except('staff_attendances'))->setPath($param);
        $staff_attendances = $filter2->latest('id')->paginate(50, ['*'], 'staff_attendances')->appends(request()->except('attendances'))->setPath($param);
        
        $staffs = User::where('supervisor_id', auth()->id())->where('status', 1)->select('id', 'name')->get();

        $setting = Setting::find(1);
        if($setting->salary_calculate == 'Nepali'){
            $datas['type'] = 1;
            $datas['year'] = Attendance::where('np_year', '!=', null)->groupBy('np_year')->orderBy('np_year', 'desc')->pluck('np_year');

            $datas['month'][] = ['id' => 1, 'title' => $this->get_nepali_month(1)];
            $datas['month'][] = ['id' => 2, 'title' => $this->get_nepali_month(2)];
            $datas['month'][] = ['id' => 3, 'title' => $this->get_nepali_month(3)];
            $datas['month'][] = ['id' => 4, 'title' => $this->get_nepali_month(4)];
            $datas['month'][] = ['id' => 5, 'title' => $this->get_nepali_month(5)];
            $datas['month'][] = ['id' => 6, 'title' => $this->get_nepali_month(6)];
            $datas['month'][] = ['id' => 7, 'title' => $this->get_nepali_month(7)];
            $datas['month'][] = ['id' => 8, 'title' => $this->get_nepali_month(8)];
            $datas['month'][] = ['id' => 9, 'title' => $this->get_nepali_month(9)];
            $datas['month'][] = ['id' => 10, 'title' => $this->get_nepali_month(10)];
            $datas['month'][] = ['id' => 11, 'title' => $this->get_nepali_month(11)];
            $datas['month'][] = ['id' => 12, 'title' => $this->get_nepali_month(12)];
        } else{
            $datas['type'] = 2;
            $datas['year'] = [date('Y'), date('Y') - 1];

            $datas['month'][] = ['id' => 1, 'title' => $this->get_english_month(1)];
            $datas['month'][] = ['id' => 2, 'title' => $this->get_english_month(2)];
            $datas['month'][] = ['id' => 3, 'title' => $this->get_english_month(3)];
            $datas['month'][] = ['id' => 4, 'title' => $this->get_english_month(4)];
            $datas['month'][] = ['id' => 5, 'title' => $this->get_english_month(5)];
            $datas['month'][] = ['id' => 6, 'title' => $this->get_english_month(6)];
            $datas['month'][] = ['id' => 7, 'title' => $this->get_english_month(7)];
            $datas['month'][] = ['id' => 8, 'title' => $this->get_english_month(8)];
            $datas['month'][] = ['id' => 9, 'title' => $this->get_english_month(9)];
            $datas['month'][] = ['id' => 10, 'title' => $this->get_english_month(10)];
            $datas['month'][] = ['id' => 11, 'title' => $this->get_english_month(11)];
            $datas['month'][] = ['id' => 12, 'title' => $this->get_english_month(12)];
        }
        return view('supervisor.pages.attendances.index',compact('attendances', 'staff_attendances', 'datas', 'staffs'));
    }

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
                'attendance_date' => $today,
                'in_time' => date('H:i:s'),
                'in_location' => $request->location,
                'np_year' => $np_today['year'],
                'np_month' => $np_today['month'],
                'np_date' => $np_today['date']
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
                $attendance->update([
                    'out_time' => date('H:i:s'),
                    'out_location' => $request->location,
                ]);
            }else{
                Attendance::create([
                    'user_id' => auth()->user()->id,
                    'attendance_date' => date('Y-m-d'),
                    'out_time' => date('H:i:s'),
                    'out_location' => $request->location,
                    'np_year' => $np_today['year'],
                    'np_month' => $np_today['month'],
                    'np_date' => $np_today['date']
                ]);
            }

        }
        return back()->with('info', 'Thank you');
    }


    public function approve($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'approve' => '1'
        ]);

        $notification = Str::toastMsg('Attendance Approved','success');
        return response($notification);

    }

    public function reject($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'approve' => '2'
        ]);

        $notification = Str::toastMsg('Attendance Rejected','success');
        return response($notification);

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
        $notification = Str::toastMsg('Attendance Approved','success');
        return back()->with($notification);
    }
    private function filterQuery($query, $option)
    {
        if(request()->filled('from')) {
            $query->whereDate('attendance_date','>=', request()->from);
        }
        if(request()->filled('to')) {
            $query->whereDate('attendance_date','<=', request()->to);
        }
        if(request()->filled('staff') && $option){
            $query->where('user_id', request()->staff);
        }
        return $query;
    }
    public function getUserAttendance(Request $request)
    {
        $user_id = 0;
        if ($request->user_id)
        {
            $user_id = $request->user_id;
        }
        $user = \App\Models\User::select('id','branch_id','name', 'supervisor_id')->where('id',$user_id)->first();
        if ($user)
        {
            $attendances = Attendance::where('user_id',$user->id)->latest('id')
                ->paginate(10)->setPath('/supervisor/report?tab=attendance');

            return view('supervisor.pages.employees.attendance', compact('attendances', 'user'))->render();
        }
        return '';


    }
}
