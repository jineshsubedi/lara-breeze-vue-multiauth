<?php

namespace Hris\Booking\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Booking\Models\BookingHall;
use Hris\Booking\Models\BookingPlace;
use Hris\Booking\Requests\BookingHallRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingHallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = BookingHall::query();
        $query->with(['place:id,title']);
        $filter = $this->filterQuery($query);
        $bookinghalls = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/BookingHalls/Index', [
            'bookinghalls' => $bookinghalls,
            'bookingplaces' => BookingPlace::orderBy('title')->get(['id', 'title']),
            'filters' => $request->only(['place', 'title'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/BookingHalls/Create',[
            'bookingplaces' => BookingPlace::orderBy('title')->get(['id', 'title']),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BookingHall\BookingHallRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookingHallRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'booking_place_id' => $request->place_id,
                'title' => $st['title'],
            ];
            BookingHall::create($data);
        }
        return redirect()->route('admin.bookinghalls.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingHall  $bookinghall
     * @return \Illuminate\Http\Response
     */
    public function show(BookingHall $bookinghall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookingHallRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingHall  $bookinghall
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingHall $bookinghall)
    {
        return Inertia::render('Admin/BookingHalls/Edit', [
            'bookinghall' => $bookinghall,
            'bookingplaces' => BookingPlace::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function update(BookingHallRequest $request, BookingHall $bookinghall)
    {
        $bookinghall->update($request->validated());
        return redirect()->route('admin.bookinghalls.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingHall  $bookinghall
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingHall $bookinghall)
    {
        $bookinghall->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        // if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        // {
        //     $query->where('branch_id', auth()->user()->branch_id);
        // }else{
        //     if(request()->filled('branch')) {
        //         $query->where('branch_id', request()->branch);
        //     }
        // }
        if(request()->filled('place')) {
            $query->where('booking_place_id', request()->place);
        }
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        return $query;
    }

}

