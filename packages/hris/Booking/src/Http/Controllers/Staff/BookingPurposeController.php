<?php

namespace Hris\Booking\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Hris\Booking\Models\BookingPurpose;
use Hris\Booking\Requests\BookingPurposeRequest;
use Inertia\Inertia;

class BookingPurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = BookingPurpose::query();
        $filter = $this->filterQuery($query);
        $bookingpurposes = $filter->orderBy('title')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Staff/BookingPurposes/Index', [
            'bookingpurposes' => $bookingpurposes
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/BookingPurposes/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BookingPurpose\BookingPurposeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookingPurposeRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            BookingPurpose::create($data);
        }
        return redirect()->route('staffs.bookingpurposes.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingPurpose  $bookingpurpose
     * @return \Illuminate\Http\Response
     */
    public function show(BookingPurpose $bookingpurpose)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookingPurposeRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingPurpose  $bookingpurpose
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingPurpose $bookingpurpose)
    {
        return Inertia::render('Staff/BookingPurposes/Edit', [
            'bookingpurpose' => $bookingpurpose
        ]);
    }

    public function update(BookingPurposeRequest $request, BookingPurpose $bookingpurpose)
    {
        $bookingpurpose->update($request->validated());
        return redirect()->route('staffs.bookingpurposes.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingPurpose  $bookingpurpose
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingPurpose $bookingpurpose)
    {
        $bookingpurpose->delete();
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
        return $query;
    }

}

