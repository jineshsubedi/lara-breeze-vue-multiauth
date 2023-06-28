<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubRatingRequest;
use App\Models\Performance;
use App\Models\SubordinateRating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OTStaffController extends Controller
{
    public function kpiRating(Request $request)
    {

    }
    public function subRating(SubRatingRequest $request)
    {
        SubordinateRating::create($request->validated() + [
            'user_id' => auth()->id(),
            'supervisor_id' => auth()->user()->supervisor_id
        ]);
        return back()->with('success', 'You have successfully update data');
    }
    public function performanceRating(Request $request)
    {
        if(isset($request->action)){
            if($request->action == 'cancel'){
                $this->validate($request, [
                    'user_id' => 'required|integer'
                ]);
                Performance::create(['user_id' => $request->user_id, 'comment_by' => auth()->id()]);
                return back()->with('success', 'You are successfully cancel staff performance review');
            }
            if($request->action == 'cancel-all'){
                $staffs = User::select('id','name')->where('supervisor_id', auth()->user()->id)->where('status', User::CURRENTLY_WORKING)->orderBy('name')->get(['id', 'name']);
                $quarter = Carbon::today()->format('Y-m');
                foreach($staffs as $staff)
                {
                    $checkCount = Performance::where('user_id', $staff->id)->where('comment_by', auth()->id())->where('created_at', 'LIKE', '%'.$quarter.'%')->count();
                    if($checkCount > 0)
                        continue;
                    Performance::create(['user_id' => $staff->id, 'comment_by' => auth()->id()]);
                }
                return back()->with('success', 'You are successfully cancel all staff performance review');
            }
        }
        $this->validate($request, [
            'user_id' => 'required|integer',
            'comment' => 'required',
            'comment_rating' => 'required'
        ],[
            'user_id.required' => 'Please Select Subordinate'
        ]);
        $data = [
            'user_id' => $request->user_id,
            'comment_by' => auth()->id(),
            'comment' => $request->comment,
            'comment_rating' => $request->comment_rating,
        ];
        Performance::create($data);
        return back()->with('success', 'You are successfully insert data');
    }
}
