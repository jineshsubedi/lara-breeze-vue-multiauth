<?php

namespace App\Http\Controllers\Staff;

use App\Enums\AppConstant;
use App\Http\Requests\CompensatoryRequest;
use App\Http\Controllers\Controller;
use App\Models\CompensatoryOff;
use App\Traits\PackageManager;
use Illuminate\Http\Request;
use App\Models\FiscalYear;
use App\Enums\StaffType;
use Inertia\Inertia;
use App\Models\User;
use Carbon\Carbon;

class CompensatoryOffController extends Controller
{
    use PackageManager;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comp = new CompensatoryOff;
        $query = $comp;
        $query = $query->where('user_id', auth()->id())->with(['user:id,name', 'informTo:id,name']);
        $filter = $this->filterQuery($query);
        $compensatories = $filter->latest('id')->paginate(10)->withQueryString();
        $waitings = $comp->with(['user:id,name', 'informTo:id,name'])->where('inform_to', auth()->id())->where('status', '0')->get();
        $datas['status'] = AppConstant::COMPENSATORY_STATUS;
        return Inertia::render('Staff/Compensatory/Index', [
            'compensatories' => $compensatories,
            'waitings' => $waitings,
            'datas' => $datas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas = $this->getData();
        return Inertia::render('Staff/Compensatory/Create',[
            'datas' => $datas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompensatoryRequest $request)
    {
        if(CompensatoryOff::where('user_id', auth()->user()->id)->where('work_day', $request->work_day)->count() > 0)
        {
            return back()->with('warning', 'You have already claimed your compensatory off on this '.$request->work_day. 'day');
        }
        CompensatoryOff::create($request->validated() + [
            'branch_id' => auth()->user()->branch_id,
            'user_id' => auth()->id()
        ]);
        return redirect()->route('staffs.compensatory.index')->with('success', 'Compensatory Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CompensatoryOff $compensatory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CompensatoryOff $compensatory)
    {
        $datas = $this->getData();
        return Inertia::render('Staff/Compensatory/Edit', [
            'compensatoryoff' => $compensatory,
            'datas' => $datas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompensatoryRequest $request, CompensatoryOff $compensatory)
    {
        $compensatory->update($request->validated());
        return redirect()->route('staffs.compensatory.index')->with('success', 'Compensatory Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompensatoryOff $compensatory)
    {
        $compensatory->delete();
        return back()->with('success', 'Compensatory Deleted Successfully');
    }

    public function approval(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer',
            'remarks' => 'required'
        ]);
        $comp = CompensatoryOff::findOrFail($id);
        $comp->update([
            'status' => $request->status == 1 ? '1' : '2',
            'remarks' => $request->remarks,
        ]);
        return back()->with('success', 'Compensatory Updated');
    }

    private function filterQuery($query)
    {
        if(request()->filled('name')) {
            $query->where('name','like', '%'. request()->name.'%');
        }

        return $query;
    }
    public function getData()
    {
        $authUser = auth()->user();
        $datas['users'] = User::active()
            ->where('branch_id', $authUser->branch_id)
            ->where(function($query) use($authUser){
                return $query->where('staff_type', StaffType::ADMIN->value)
                ->orWhere('id', $authUser->supervisor_id);
            })
            ->groupBy('id')
            ->orderBy('name')
            ->get(['id', 'name']);
        $holidays = array_unique(array_merge($this->getUserWeekendDays(), $this->getAllHolidays()));
        $datas['holidays'] = $holidays;
        return $datas;
    }
    
}
