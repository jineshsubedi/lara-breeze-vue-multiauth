<?php

namespace Hris\Booking\Http\Controllers\Supervisor;

use App\Enums\AppConstant;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Hris\Booking\Models\Booking;
use Hris\Booking\Models\BookingPlace;
use Hris\Booking\Models\BookingPurpose;
use Hris\Booking\Models\BookingStaffs;
use Hris\Booking\Notifications\BookingNotification;
use Hris\Booking\Requests\BookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Booking::query();
        $query->with(['branch:id,name', 'place:id,title', 'hall:id,title', 'purpose:id,title', 'user:id,name']);
        $filter = $this->filterQuery($query);
        $bookings = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Bookings/Index', [
            'bookings' => $bookings,
            'datas' => $this->getData(),
            'filters' => $request->only(['hall', 'place', 'purpose', 'staff', 'branch', 'type'])
        ]);

    }
    public function getData()
    {
        $data['branches'] = Branch::branchList();
        $data['purposes'] = BookingPurpose::orderBy('title')->get(['id', 'title']);
        $data['places'] = BookingPlace::orderBy('title')->get(['id', 'title']);
        $data['halls'] = [];
        $data['staffs'] = User::active();
        if(request()->filled('branch')) {
            $data['staffs'] = $data['staffs']->where('branch_id', request()->branch);
        }else{
            $data['staffs'] = $data['staffs']->where('branch_id', auth()->user()->branch_id);
        }
        $data['staffs'] = $data['staffs']->orderBy('name')->get(['id','name']);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Bookings/Create',[
            'datas' => $this->getData()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Booking\BookingRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        $booking = Booking::where('hall_id',$request->hall_id)
                    ->where('booking_date',$request->booking_date)
                    ->where('start_time', '<=', $request->start_time)
                    ->where('end_time', '>=', $request->end_time)
                    ->count();
        if ($booking > 0) {
            return back()->with('danger', 'Sorry This is already booked on this time');
        }
        Booking::create($request->validated());
        return redirect()->route('supervisor.bookings.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $booking->load(['branch:id,name', 'place:id,title', 'hall:id,title', 'purpose:id,title', 'user:id,name', 'staffs' => function($query){
            $query->with('user:id,name');
        }]);
        $myparticipant = BookingStaffs::where('booking_id', $booking->id)->where('staff_id', auth()->id())->where('status', StatusType::PENDING->value)->first();
        return Inertia::render('Supervisor/Bookings/Show', [
            'booking' => $booking,
            'myparticipant' => $myparticipant,
            'statuss' => AppConstant::YN
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookingRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        return Inertia::render('Supervisor/Bookings/Edit', [
            'booking' => $booking,
            'datas' => $this->getData()
        ]);
    }

    public function update(BookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return redirect()->route('supervisor.bookings.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }else{
            if(request()->filled('branch')) {
                $query->where('branch_id', request()->branch);
            }
        }
        if(request()->filled('hall')) {
            $query->where('hall_id', request()->hall);
        }
        if(request()->filled('place')) {
            $query->where('place_id', request()->place);
        }
        if(request()->filled('purpose')) {
            $query->where('purpose_id', request()->purpose);
        }
        if(request()->filled('staff')) {
            $query->where('booked_by', request()->staff);
        }
        if(request()->filled('type')) {
            if(request()->type == '1'){
                $query->where('booked_by', auth()->id());
            }else{
                $booking_ids = BookingStaffs::where('staff_id', auth()->id())->pluck('booking_id');
                $query->whereIn('id', $booking_ids);
            }
        }else{
            $booking_ids = BookingStaffs::where('staff_id', auth()->id())->pluck('booking_id');
            $query->whereIn('id', $booking_ids);
        }
        return $query;
    }

    public function getParticipants($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->load(['staffs' => function($query){
            $query->with('user:id,name');
        }]);
        return Inertia::render('Supervisor/Bookings/Members',[
            'booking' => $booking,
            'staffs' => User::active()->branchId()->get(['id', 'name'])
        ]);
    }
    public function saveParticipants($id, Request $request)
    {
        $this->validate($request, [
            'booking_id' => 'required|integer',
            'category.*.staff_id' => 'required|integer'
        ]);
        $booking = Booking::findOrFail($id);
        if($booking->id != $request->booking_id)
            return back()->with('danger', 'Participants cannot be added');
        
        foreach($request->category as $category)
        {
            $user = User::select('id', 'name', 'staff_type')->findOrFail($category['staff_id']);
            if(isset($user->id))
            {
                BookingStaffs::updateOrCreate([
                    'booking_id' => $id,
                    'staff_id' => $user->id
                ]);
                $message = auth()->user()->name.' has invited you for the scheduled booking.'; 
                $link = $this->staffUrl($user, $booking->id);
                Notification::send($user, new BookingNotification($booking, $message, $link));
            }
        }
        return back()->with('success', 'Participants Added');
    }
    public function removeParticipants($id)
    {
        $booking = BookingStaffs::findOrFail($id);
        $booking->delete();
        return back()->with('success', 'Record Deleted');
    }

    public function updateStatus($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:0,1'
        ]);
        if($request->status == 0)
        {
            $this->validate($request, [
                'remarks' => 'required|max:200'
            ]);
        }
        BookingStaffs::findOrFail($id)->update([
            'status' => $request->status == 1 ? 1 : 2,
            'remarks' => $request->remarks
        ]);
        return back()->with('success', 'Invitation Updated');
    }

    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('supervisor.bookings.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.bookings.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.bookings.show', $id);
        }
    }
}

