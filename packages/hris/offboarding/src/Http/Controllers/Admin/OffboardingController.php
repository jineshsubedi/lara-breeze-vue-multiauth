<?php

namespace Hris\Offboarding\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class OffboardingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:HrHandler|SuperAdmin');
    }
    public function index()
    {
        $departmentIds = Department::where('branch_id', auth()->user()->branch_id)->pluck('id');
        $staffs = [];

        // if(Department::where('id', auth()->user()->department_id)->where('department_head', auth()->id())->first())
        // {
        //     $staffs = DepartmentApproval::where('department_id',auth()->guard('staffs')->user()->department)->where('settlement_approval', 0)->orderBy('created_at', 'desc')->get();
        // }
    }
}
