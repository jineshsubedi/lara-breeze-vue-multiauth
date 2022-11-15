<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
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
}
