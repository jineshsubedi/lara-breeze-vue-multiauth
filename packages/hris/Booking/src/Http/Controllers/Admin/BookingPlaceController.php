<?php

namespace Hris\Booking\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Booking\Models\BookingPlace;
use Hris\Booking\Requests\BookingPlaceRequest;
use Inertia\Inertia;

class BookingPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = BookingPlace::query();
        $filter = $this->filterQuery($query);
        $bookingplaces = $filter->orderBy('title')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/BookingPlaces/Index', [
            'bookingplaces' => $bookingplaces
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/BookingPlaces/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BookingPlace\BookingPlaceRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookingPlaceRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            BookingPlace::create($data);
        }
        return redirect()->route('admin.bookingplaces.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingPlace  $bookingplace
     * @return \Illuminate\Http\Response
     */
    public function show(BookingPlace $bookingplace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookingPlaceRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingPlace  $bookingplace
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingPlace $bookingplace)
    {
        return Inertia::render('Admin/BookingPlaces/Edit', [
            'bookingplace' => $bookingplace
        ]);
    }

    public function update(BookingPlaceRequest $request, BookingPlace $bookingplace)
    {
        $bookingplace->update($request->validated());
        return redirect()->route('admin.bookingplaces.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingPlace  $bookingplace
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingPlace $bookingplace)
    {
        $bookingplace->delete();
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

