<?php

namespace Hris\Attendance\Http\Controllers\Staff;

use Hris\Attendance\Requests\GenerateAttendanceRequest;
use Hris\Attendance\Models\Attendance;
use App\Http\Controllers\Controller;
use App\Library\NepaliDateApi;
use App\Models\BranchSetting;
use Illuminate\Http\Request;
use App\Enums\AppConstant;
use Inertia\Inertia;
use App\Models\User;
use App\Traits\PackageManager;
use Carbon\Carbon;
use Hris\Attendance\Exports\MultipleMonthlyAttendance;
use Illuminate\Support\Facades\Storage;

class AttendanceHandlerController extends Controller
{
    use NepaliDateApi, PackageManager;

    public function __construct()
    {
        $this->middleware('role:AttendanceHandler');
    }
    public function index(Request $request)
    {
        $query = Attendance::with('user:id,name')->where('branch_id', auth()->user()->branch_id);
        $filter = $this->filterQuery($query);
        $attendances = $filter->orderBy('id', 'desc')->paginate(30)->withQueryString();
        $staffs = User::active()->where('branch_id', auth()->user()->branch_id)->get(['id', 'name']);
        $dateType = BranchSetting::where('branch_id', auth()->user()->branch_id)->first();
        $astatus = AppConstant::ATTENDANCE_STATUS;
        $excelFile = Storage::exists('export/staffAttendance.xlsx') ? Storage::url('export/staffAttendance.xlsx') : null;
        return Inertia::render('Staff/Attendance/Main', [
            'attendances' => fn () => $attendances, // required for partial reload
            'staffs' => $staffs,
            'astatus' => $astatus,
            'excelFile' => $excelFile,
            'dateType' => $dateType->salary_calculate ?: 2,
            'filters' => $request->only(['staff', 'from', 'to', 'status'])
        ]);
    }
    public function approve(Request $request)
    {
        if (is_array($request->selected) && count($request->selected) > 0) {
            for ($i = 0; $i < count($request->selected); $i++) {
                Attendance::find($request->selected[$i])->update(['approve' => '1']);
            }
            return back()->with('info', 'Approved');
        }
    }
    public function generate(GenerateAttendanceRequest $request)
    {
        $userData = User::with('address')->findOrFail($request->staff);
        $defaultLocation = isset($userData->address) ? $userData->address->primary_location : AppConstant::LOCATION;
        if ($request->type == 1) {
            $nepali_year = $request->year;
            $nepali_month = $request->month;
            for ($i = $request->start_day; $i <= $request->end_day; $i++) {
                $date = $this->nep_to_eng($request->year, $request->month, $i);
                $english_year = $date['year'];
                $english_month = $date['month'];
                $day = $date['date'];
                $carbon_date = Carbon::create($english_year, $english_month, $day);
                $check = Attendance::where('user_id', $request->staff)->where('attendance_date', $carbon_date->format('Y-m-d'))->first();
                $holiday = $this->getHoliday($carbon_date->format('Y-m-d'));
                // $leave = LeaveRequest::where('requested_by', $request->staff)->where('supervisor_approval', 1)->where('hr_approval', 1)->whereDate('start_date', '>=', $carbon_date->format('Y-m-d'))->where('start_date', '<=', $carbon_date->format('Y-m-d'))->get();
                User::setWeekend();
                if ($carbon_date->isWeekend()) {
                    continue;
                } elseif ($check) {
                    continue;
                }
                elseif($holiday){
                    continue;
                }
                // elseif(count($leave)>0){
                //     continue;
                // }
                else {

                    $data[] = [
                        'user_id' => $request->staff,
                        'branch_id' => $userData->branch_id,
                        'attendance_date' => $carbon_date->format('Y-m-d'),
                        'in_time' => $request->in_time,
                        'out_time' => $request->out_time,
                        'in_location' => $defaultLocation,
                        'out_location' => $defaultLocation,
                        'np_year' => $nepali_year,
                        'np_month' => $nepali_month,
                        'np_date' => $i,
                        'approve' => '1',
                        'manual' => '1',
                        'remarks' => $request->remarks,
                    ];
                }
            }
        } else {
            $english_year = $request->year;
            $english_month = $request->month;
            for ($i = $request->start_day; $i <= $request->end_day; $i++) {
                $date = $this->eng_to_nep($request->year, $request->month, $i);
                $nepali_year = $date['year'];
                $nepali_month = $date['month'];
                $day = $date['date'];
                $carbon_date = Carbon::create($english_year, $english_month, $i);
                $check = Attendance::where('user_id', $request->staff)->where('attendance_date', $carbon_date->format('Y-m-d'))->first();
                $holiday = $this->getHoliday($carbon_date->format('Y-m-d'));
                // $leave = LeaveRequest::where('requested_by', $request->staff)->where('supervisor_approval', 1)->where('hr_approval', 1)->whereDate('start_date', '>=', $carbon_date->format('Y-m-d'))->where('start_date', '<=', $carbon_date->format('Y-m-d'))->get();
                User::setWeekend();
                if ($carbon_date->isWeekend()) {
                    continue;
                } elseif ($check) {
                    continue;
                }
                elseif($holiday){
                    continue;
                }
                // elseif(count($leave)>0){
                //     continue;
                // }
                else {
                    $data[] = [
                        'user_id' => $request->staff,
                        'branch_id' => $userData->branch_id,
                        'attendance_date' => $carbon_date->format('Y-m-d'),
                        'in_time' => $request->in_time,
                        'out_time' => $request->out_time,
                        'in_location' => $defaultLocation,
                        'out_location' => $defaultLocation,
                        'np_year' => $nepali_year,
                        'np_month' => $nepali_month,
                        'np_date' => $i,
                        'approve' => '1',
                        'manual' => '1',
                        'remarks' => $request->remarks,
                    ];
                }
            }
        }
        if (count($data) > 0)
            Attendance::insert($data);

        return back()->with('success', 'Attendance Geneareted Successfully!');
    }
    public function export(Request $request)
    {
        $e_attendance = [];
        $e_staff = [];
        $end_day = $this->bsd[$request->year][$request->month];
        if ($request->staff == 'all') {
            $staffs = User::where('branch_id', auth()->user()->branch_id)->active()->select('id', 'name', 'email', 'weekend')->get();
            $filename = 'All-Staff-attendance.xlsx';
        } else {
            $staff =  User::select('id', 'name', 'email', 'weekend')->find($request->staff);
            $staffs[] = $staff;
            $filename = $staff->name . '-' . $request->year . '-' . $request->month . '-attendance.xlsx';
        }
        foreach ($staffs as $staff) {
            for ($i = 1; $i <= $end_day; $i++) {
                $np_date = $request->year . '-' . $request->month . '-' . $i;
                $attendance = Attendance::where('branch_id', auth()->user()->branch_id)
                    ->where('user_id', $staff->id)
                    ->where('np_year', $request->year)
                    ->where('np_month', $request->month)
                    ->where('np_date', $i)
                    ->select('id', 'attendance_date', 'in_time', 'in_location', 'out_time', 'out_location', 'approve', 'in_time_reason', 'out_time_reason', 'in_away_location', 'out_away_location', 'remarks', 'lunch_start', 'lunch_end')
                    ->first();

                $engDate = $this->nep_to_eng($request->year, $request->month, $i);
                $eng_date = $engDate['year'] . '-' . $engDate['month'] . '-' . $engDate['date'];
                $week_en = $engDate['eday'];
                $week_np = $engDate['day'];
                $remark = '';

                if (isset($attendance->id)) {
                    $remark .= $attendance->in_time_reason != '' ? ' Late In->' . $attendance->in_time_reason : '' . ' ';
                    $remark .= $attendance->out_time_reason != '' ? ' Early Out->' . $attendance->out_time_reason : '' . ' ';
                    $remark .= $attendance->in_away_location != '' ? ' Away In->' . $attendance->in_away_location : '' . ' ';
                    $remark .= $attendance->out_away_location != '' ? ' Away Out->' . $attendance->out_away_location : '' . ' ';
                    $remark .= $attendance->remarks != '' ? ' Hr ->' . $attendance->remarks : '';
                    $e_attendance[$staff->name][] = [
                        'a_date' => $attendance->attendance_date,
                        'n_date' => $np_date,
                        'e_date' => $eng_date,
                        'clock_in' => $attendance->in_time,
                        'clock_out' => $attendance->out_time,
                        'duration' => $attendance->attendance_duration,
                        'in_location' => $attendance->in_location,
                        'out_location' => $attendance->out_location,
                        'status' => $attendance->approve == '1' ? 'Approved' : 'Pending',
                        'remarks' => $remark,
                        'attendance_type' => 'Work',
                        'week' => $week_np,
                    ];
                } else {
                    // $leave_request = LeaveRequest::where('requested_by', $staff->id)->where('start_date', '<=', $eng_date)->where('end_date', '>=', $eng_date)->select('id', 'requested_by', 'leave_type', 'full_day', 'description', 'supervisor_approval', 'hr_approval', 'chairman_approval', 'types')->first();
                    $staff_week = $staff->weekend;
                    $holiday = $this->getHoliday($eng_date);
                    if (in_array(strtoupper($week_en), $staff_week)) {
                        $e_attendance[$staff->name][] = [
                            'n_date' => $np_date,
                            'e_date' => $eng_date,
                            'clock_in' => '',
                            'clock_out' => '',
                            'duration' => '',
                            'in_location' => '',
                            'out_location' => '',
                            'status' => '',
                            'remarks' => $remark,
                            'attendance_type' => 'Week Off',
                            'week' => $week_np,
                        ];
                    }
                    // else if(isset($leave_request->id))
                    // {
                    //     // $setting = \App\ra_model\LeaveSetting::where('branch_id', auth()->guard('staffs')->user()->branch)->first();
                    //     // $remark = 'UnApproved';
                    //     // if($setting->supervisor_required == 1)
                    //     // {
                    //     //     if($leave_request->supervisor_approval == 1)
                    //     //     {
                    //     //     $remark = 'Approved';
                    //     //     }
                    //     // }
                    //     // if($setting->approval_required == 1)
                    //     // {
                    //     //     if($leave_request->hr_approval == 1)
                    //     //     {
                    //     //     $remark = 'Approved';
                    //     //     }else{
                    //     //     $remark = 'Pending';
                    //     //     }
                    //     // }
                    //     // if($setting->chairman_required == 1)
                    //     // {
                    //     //     if($leave_request->chairman_approval == 1)
                    //     //     {
                    //     //     $remark = 'Approved';
                    //     //     }else{
                    //     //     $remark = 'Pending';
                    //     //     }
                    //     // }
                    //     // $leave_type = \App\ra_model\LeaveType::getTitle($leave_request->leave_type);
                    //     // $e_attendance[$staff->name][] = [
                    //     //     'n_date' => $np_date,
                    //     //     'e_date' => $eng_date,
                    //     //     'clock_in' => '',
                    //     //     'clock_out' => '',
                    //     //     'duration' => '',
                    //     //     'in_location' => '',
                    //     //     'out_location' => '',
                    //     //     'status' => $leave_request->types == 1 ? 'UnPaid' : 'Paid',
                    //     //     'remarks' => $remark,
                    //     //     'attendance_type' => 'Leave ('.$leave_type.')',
                    //     //     'week' => $week_np,
                    //     // ];
                    // }
                    else if(isset($holiday->id))
                    {
                        $e_attendance[$staff->name][] = [
                            'n_date' => $np_date,
                            'e_date' => $eng_date,
                            'clock_in' => '',
                            'clock_out' => '',
                            'duration' => '',
                            'in_location' => '',
                            'out_location' => '',
                            'status' => '',
                            'remarks' => $remark,
                            'attendance_type' => 'Holiday- '.$holiday->title,
                            'week' => $week_np,
                        ];
                    }
                    else {
                        $e_attendance[$staff->name][] = [
                            'n_date' => $np_date,
                            'e_date' => $eng_date,
                            'clock_in' => '',
                            'clock_out' => '',
                            'duration' => '',
                            'in_location' => '',
                            'out_location' => '',
                            'status' => '',
                            'remarks' => $remark,
                            'attendance_type' => 'Absent',
                            'week' => $week_np,
                        ];
                    }
                }
            }
            $e_staff[] = $staff;
        }
        $datas['staffs'] = $e_staff;
        $datas['attendance'] = $e_attendance;
        (new MultipleMonthlyAttendance($datas))->store('export/staffAttendance.xlsx', 'public');
    }
    private function filterQuery($query)
    {
        if (request()->filled('from')) {
            $query->where('task_from', request()->from);
        }
        if (request()->filled('to')) {
            $query->where('task_to', request()->to);
        }
        if (request()->filled('status')) {
            $query->where('approve', '' . request()->status . '');
        }
        if (request()->filled('staff')) {
            $query->where('user_id', request()->staff);
        }
        return $query;
    }
}
