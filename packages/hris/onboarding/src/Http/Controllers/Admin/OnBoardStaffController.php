<?php

namespace Hris\Onboarding\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\UserDocument;
use Hris\Hrletter\Models\LetterType;
use Hris\Onboarding\Enums\OnboardStatus;
use Hris\Onboarding\Models\OnBoardStaff;
use Hris\Onboarding\Requests\OnBoardStaffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OnBoardStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = OnBoardStaff::query();
        $filter = $this->filterQuery($query);
        $onboardstaffs = $filter->latest();

        switch (request()->tab) {
            case 'supervisor':
                $onboardstaffs = $onboardstaffs
                    ->where('supervisor_approval', OnboardStatus::PENDING->value)
                    ->where('supervisor_id', auth()->id());
                break;
            case 'hr':
                $onboardstaffs = $onboardstaffs
                    ->where('supervisor_approval', OnboardStatus::ACCEPT->value)
                    ->where('hr_approval', OnboardStatus::PENDING->value);
                break;
            case 'rejected':
                $onboardstaffs = $onboardstaffs
                    ->where(function ($query) {
                        $query->where('supervisor_approval', OnboardStatus::REJECT->value)
                            ->orWhere('hr_approval', OnboardStatus::REJECT->value);
                    });
                break;
            default:
                $onboardstaffs = $onboardstaffs
                    ->where(function($q){
                        $q->where('supervisor_approval', '!=', OnboardStatus::REJECT->value)
                        ->where('hr_approval', '!=', OnboardStatus::REJECT->value);
                    });
                break;
        }

        $onboardstaffs = $onboardstaffs->paginate(20)->withQueryString();

        return Inertia::render('Admin/OnBoardStaffs/Index', [
            'onboardstaffs' => $onboardstaffs,
            'ostatus' => config('onboardConstant.status'),
            'filters' => request()->only(['name', 'email', 'tab'])
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/OnBoardStaffs/Create',[
            'datas' => $this->getData(),
        ]);
    }

    private function getData()
    {
        $data['users'] = User::active()->branchId()->get(['id', 'name']);
        $data['departments'] = Department::where('branch_id', auth()->user()->branch_id)->get();
        try {
            $data['letters'] = LetterType::orderBy('title')->get(['id', 'title']);
        } catch (\Throwable $th) {
            $data['letters'] = [];
        }
        $data['nature'] = config('onboardConstant.nature');
        $data['employment'] = config('onboardConstant.employment');
        $data['trail'] = config('onboardConstant.trail');
        $data['staff_type'] = config('onboardConstant.staff_types');

        return $data;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OnBoardStaff\OnBoardStaffRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OnBoardStaffRequest $request)
    {
        OnBoardStaff::create($request->validated() + [
            'cv' => $request->hasFile('cvFile') ? ($request->file('cvFile')->store('onboard_staff', 'public')) : '',
        ]);
        return redirect()->route('admin.onboardings.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OnBoardStaff  $onboardstaff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $onboardstaff = OnBoardStaff::findOrFail($id);
        $onboardstaff->load(['supervisor:id,name', 'department:id,title', 'designation:id,title', 'letter:id,title']);
        return Inertia::render('Admin/OnBoardStaffs/Show', [
            'onboardstaff' => $onboardstaff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OnBoardStaffRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OnBoardStaff  $onboardstaff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $onboardstaff = OnBoardStaff::findOrFail($id);
        return Inertia::render('Admin/OnBoardStaffs/Edit', [
            'onboardstaff' => $onboardstaff,
            'datas' => $this->getData(),
        ]);
    }

    public function update(OnBoardStaffRequest $request, $id)
    {
        $onboardstaff = OnBoardStaff::findOrFail($id);
        $cv = $onboardstaff->getRawOriginal('cv');
        if($request->hasFile('cvFile'))
        {
            if(Storage::exists($cv))
            {
                Storage::delete($cv);
            }
            $cv = $request->file('cvFile')->store('onboard_staff', 'public');
        }
        $onboardstaff->update($request->validated() + [
            'cv' => $cv
        ]);
        return redirect()->route('admin.onboardings.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OnBoardStaff  $onboardstaff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $onboardstaff = OnBoardStaff::findOrFail($id);
        $cv = $onboardstaff->getRawOriginal('cv');
        if(Storage::exists($cv))
        {
            Storage::delete($cv);
        }
        $onboardstaff->delete();
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
        if(request()->filled('name')) {
            $query->where('name', 'LIKE', '%'.request()->name.'%');
        }
        if(request()->filled('email')) {
            $query->where('email', 'LIKE', '%'.request()->email.'%');
        }
        return $query;
    }

    public function approve(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'type' => 'required|string',
            'status' => 'required|in:Accepted,Rejected',
            'comment' => 'required|max:500',
        ]);
        if($request->type == 'supervisor')
        {
            OnBoardStaff::where('id', $request->id)->update([
                'supervisor_approval' => $request->status,
                'supervisor_comment' => $request->comment,
                'supervisor_approval_date' => Date('Y-m-d'),
            ]);
        }
        if($request->type == 'hr')
        {
            OnBoardStaff::where('id', $request->id)->update([
                'hr_approval' => $request->status,
                'hr_comment' => $request->comment,
                'hr_approval_date' => Date('Y-m-d'),
            ]);
        }
        return back()->with('success', 'Onboard Staff Updated');
    }

}

