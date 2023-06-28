<?php

namespace Hris\Travel\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\LeaveSetting;
use App\Models\User;
use Hris\Travel\Models\Travel;
use Hris\Travel\Models\TravelAir;
use Hris\Travel\Models\TravelHotelBooking;
use Hris\Travel\Models\TravelItinery;
use Hris\Travel\Models\TravelPlanner;
use Hris\Travel\Models\TravelRoad;
use Hris\Travel\Models\TravelVisa;
use Hris\Travel\Requests\TravelPlannerRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TravelPlannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = TravelPlanner::query()->with(['travel:id,type,unique_id']);
        $travelplanners = $this->filterQuery($query)
                                ->where('branch_id', auth()->user()->branch_id)
                                ->when(request()->tab === 'waiting', function ($query) {
                                    return $query->where(function ($query) {
                                        return $query->where('supervisor_approval', 0)
                                                    ->orWhere('hr_approval', 0)
                                                    ->orWhere('chairman_approval', 0);
                                    });
                                })
                                ->when(request()->tab === null, function ($query) {
                                    return $query->where('staff_id', auth()->id());
                                })
                                ->when(request()->tab === 'all', function ($query) {
                                    // return $query->where('staff_id', auth()->id());
                                })
                                ->latest('id', 'desc')
                                ->paginate(20)
                                ->withQueryString();

        return Inertia::render('Admin/Travel/Planners/Index', [
            'travelplanners' => $travelplanners,
            'filters' => request()->only(['tab'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $travels = Travel::where('assigned_to', auth()->id())
            ->orWhere('assigned_from', auth()->id())
            // ->where('supervisor_approval', 1)
            ->where('account_approval', 0)
            ->orderBy('id','desc')
            ->select('id', 'unique_id', 'from', 'to')
            ->get();
        return Inertia::render('Admin/Travel/Planners/Create',[
            'travels' => $travels,
            'departments' => Department::where('branch_id', auth()->user()->branch_id)
                                ->orderBy('title')
                                ->get(),
            'staffs' => User::active()->branchId()->get(['id', 'name'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TravelPlanner\TravelPlannerRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TravelPlannerRequest $request)
    {
        $travel = Travel::findOrFail($request->travel_id);
        $planner = TravelPlanner::create([
            'branch_id' => $travel->branch_id,
            'travel_id' => $travel->id,
            'staff_id' => $travel->assigned_to
        ]);

        if($request->itinery)
        {
            foreach($request->itinery as $itinery)
            {
                TravelItinery::create([
                    'travel_planner_id' => $planner->id,
                    'date' => $itinery['date'],
                    'travel_from' => $itinery['travel_from'],
                    'travel_to' => $itinery['travel_to'],
                    'time_from' => $itinery['time_from'],
                    'time_to' => $itinery['time_to'],
                    'description' => $itinery['description'],
                ]);
            }
        }
        if($request->road)
        {
            foreach($request->road as $road)
            {
                TravelRoad::create([
                    'travel_planner_id' => $planner->id,
                    'vehicle_number' => $road['vehicle_number'],
                    'driver_name' => $road['driver_name'],
                    'driver_number' => $road['driver_number'],
                    'vendor_name' => $road['vendor_name'],
                    'bus_number' => $road['bus_number'],
                ]);
            }
        }
        if($request->air)
        {
            foreach($request->air as $air)
            {
                TravelAir::create([
                    'travel_planner_id' => $planner->id,
                    'flight_number' => $air['flight_number'],
                    'airline_name' => $air['airline_name'],
                    'departure_on' => $air['departure_on'],
                    'arrival_on' => $air['arrival_on'],
                ]);
            }
        }
        if($request->hotel)
        {
            foreach($request->hotel as $hotel)
            {
                TravelHotelBooking::create([
                    'travel_planner_id' => $planner->id,
                    'name' => $hotel['hotel_name'],
                    'number' => $hotel['hotel_number'],
                    'departure_at' => $hotel['departure_at'],
                    'arrival_at' => $hotel['arrival_at'],
                    'place_name' => $hotel['place'],
                    'district' => $hotel['district'],
                ]);
            }
        }
        if($request->user_id || $request->department_id)
        {
            TravelVisa::create([
                'travel_planner_id' => $planner->id,
                'user_id' => $request->user_id,
                'department_id' => $request->department_id
            ]);
        }
        return redirect()->route('admin.travelplanners.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TravelPlanner  $travelplanner
     * @return \Illuminate\Http\Response
     */
    public function show(TravelPlanner $travelplanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TravelPlannerRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TravelPlanner  $travelplanner
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelPlanner $travelplanner)
    {
        $travelplanner->load(['itinery', 'road', 'air', 'hotel', 'visa']);
        $travels = Travel::where('assigned_to', auth()->id())
            ->orWhere('assigned_from', auth()->id())
            // ->where('supervisor_approval', 1)
            ->where('account_approval', 0)
            ->orderBy('id','desc')
            ->select('id', 'unique_id', 'from', 'to')
            ->get();
        return Inertia::render('Admin/Travel/Planners/Edit', [
            'planner' => $travelplanner,
            'travels' => $travels,
            'departments' => Department::where('branch_id', auth()->user()->branch_id)
                                ->orderBy('title')
                                ->get(),
            'staffs' => User::active()->branchId()->get(['id', 'name'])
        ]);
    }

    public function update(TravelPlannerRequest $request, TravelPlanner $travelplanner)
    {
        $travelplanner->update(['travel_id' => $request->travel_id]);
        TravelItinery::where('travel_planner_id', $travelplanner->id)->delete();
        if($request->itinery)
        {
            foreach($request->itinery as $itinery)
            {
                TravelItinery::create([
                    'travel_planner_id' => $travelplanner->id,
                    'date' => $itinery['date'],
                    'travel_from' => $itinery['travel_from'],
                    'travel_to' => $itinery['travel_to'],
                    'time_from' => $itinery['time_from'],
                    'time_to' => $itinery['time_to'],
                    'description' => $itinery['description'],
                ]);
            }
        }
        TravelRoad::where('travel_planner_id', $travelplanner->id)->delete();
        if($request->road)
        {
            foreach($request->road as $road)
            {
                TravelRoad::create([
                    'travel_planner_id' => $travelplanner->id,
                    'vehicle_number' => $road['vehicle_number'],
                    'driver_name' => $road['driver_name'],
                    'driver_number' => $road['driver_number'],
                    'vendor_name' => $road['vendor_name'],
                    'bus_number' => $road['bus_number'],
                ]);
            }
        }
        TravelAir::where('travel_planner_id', $travelplanner->id)->delete();
        if($request->air)
        {
            foreach($request->air as $air)
            {
                TravelAir::create([
                    'travel_planner_id' => $travelplanner->id,
                    'flight_number' => $air['flight_number'],
                    'airline_name' => $air['airline_name'],
                    'departure_on' => $air['departure_on'],
                    'arrival_on' => $air['arrival_on'],
                ]);
            }
        }
        TravelHotelBooking::where('travel_planner_id', $travelplanner->id)->delete();
        if($request->hotel)
        {
            foreach($request->hotel as $hotel)
            {
                TravelHotelBooking::create([
                    'travel_planner_id' => $travelplanner->id,
                    'name' => $hotel['name'],
                    'number' => $hotel['number'],
                    'departure_at' => $hotel['departure_at'],
                    'arrival_at' => $hotel['arrival_at'],
                    'place_name' => $hotel['place_name'],
                    'district' => $hotel['district'],
                ]);
            }
        }
        if($request->user_id || $request->department_id)
        {
            TravelVisa::updateOrCreate([
                'travel_planner_id' => $travelplanner->id,
            ],[
                'user_id' => $request->user_id,
                'department_id' => $request->department_id
            ]);
        }
        return redirect()->route('admin.travelplanners.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TravelPlanner  $travelplanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelPlanner $travelplanner)
    {
        $travelplanner->delete();
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

    public function approval($id, Request $request)
    {
        $this->validate($request, [
            'action' => 'required'
        ]);
        $planner = TravelPlanner::findOrFail($id);
        $approval = ($request->action == 'Approve') ? 1 : 2;
        if ($planner->supervisor_approval == 0 && User::active()->where('supervisor_id', auth()->id())->pluck('id')->contains($planner->staff_id)) {
            $planner->update(['supervisor_approval' => $approval]);
        } elseif ($planner->hr_approval == 0 && auth()->user()->roles->where('name', 'HrHandler')->first()) 
        {
            $planner->update(['hr_approval' => $approval]);
        } elseif ($planner->chairman_approval == 0 && LeaveSetting::where('branch_id', auth()->user()->branch_id)->first()->m_person == auth()->id()) {
            $planner->update(['chairman_approval' => $approval]);
        }
        return redirect()->back()->with('success', 'Record have been updated Successfully');
    }

}

