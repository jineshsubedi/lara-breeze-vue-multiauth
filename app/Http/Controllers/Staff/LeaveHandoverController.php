<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LeaveHandover;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaveHandoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $handovers = LeaveHandover::with(['leave' => function($query) {
            $query->with(['user:id,name', 'leaveType:id,title'])->select('id','user_id','leave_type_id','start_date','end_date');
        }])->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Staff/Handover/Index', [
            'handovers' => $handovers,
        ]);
    }

    public function acceptAll(Request $request)
    {
        $this->validate($request, [
            'selected.*' => 'required',
        ]);
        foreach($request->selected as $select)
        {
            LeaveHandover::where('id', $select)->update(['status' => '1']);
        }
        return back()->with('success', 'Handover Request Accept Successfully');
    }
}
