<?php

namespace App\Http\Controllers\Common;

use Hris\Booking\Models\BookingHall;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Faculty;
use App\Models\ShiftTime;
use App\Models\User;
use App\Models\UserKra;

class CommonController extends Controller
{
    public function getDistrict()
    {
        return District::orderBy('title', 'asc')
            ->when(request('province'), function ($q) {
                return $q->where('province_id', request('province'));
            })
            ->get(['id', 'title', 'province_id']); 
    }
    public function getStaffsByBranch(Request $request)
    {
        $this->validate($request, [
            'branch' => ['required','integer'],
        ]);
        return User::where('branch_id', $request->branch)
            ->get(['id', 'name']); 
    }
    public function getDepartmentByBranch(Request $request)
    {
        $this->validate($request, [
            'branch' => ['required','integer'],
        ]);
        return Department::where('branch_id', $request->branch)
            ->get(['id', 'title']); 
    }
    public function getStaffByDepartment(Request $request)
    {
        $this->validate($request, [
            'department' => ['required','integer'],
        ]);
        return User::where('department_id', $request->department)
            ->get(['id', 'name']); 
    }
    public function getShiftsByBranch(Request $request)
    {
        $this->validate($request, [
            'branch' => ['required','integer'],
        ]);
        return ShiftTime::where('branch_id', $request->branch)
            ->get(['id', 'title', 'start_time', 'end_time']); 
    }
    public function getDepartmentsByBranch(Request $request)
    {
        $this->validate($request, [
            'branch' => ['required','integer'],
        ]);
        return Department::where('branch_id', $request->branch)
            ->get(['id', 'title']); 
    }
    public function getDesignationByDepartment(Request $request)
    {
        $this->validate($request, [
            'department' => ['required','integer'],
        ]);
        return Designation::where('department_id', $request->department)
            ->get(['id', 'title']); 
    }
    public function getSubOrdinates(Request $request)
    {
        $this->validate($request, [
            'branch' => ['required','integer'],
        ]);
        return User::where('branch_id', $request->branch)
            ->where('supervisor_id', auth()->id())
            ->get(['id', 'name']);
    }
    public function getStaffsKra(Request $request)
    {
        $this->validate($request, [
            'staff' => ['required','integer'],
        ]);
        return UserKra::where('user_id', $request->staff)
            ->get(['id', 'user_id', 'title']); 
    }
    public function getHallByPlaceId(Request $request)
    {
        $this->validate($request, [
            'place' => 'required|integer'
        ]);
        return BookingHall::where('booking_place_id', $request->place)->orderBy('title')->get(['id', 'title']);
    }
    public function getFacultyByEducationId(Request $request)
    {
        $this->validate($request, [
            'education' => 'required|integer'
        ]);
        return Faculty::where('education_id', $request->education)->orderBy('title')->get(['id', 'title']);
    }
    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
