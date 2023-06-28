<?php

namespace Hris\Outsource\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Hris\Outsource\Exports\OutsourceStaffExport;
use Hris\Outsource\Imports\OutSourceStaffImport;
use Hris\Outsource\Models\Outsource;
use Hris\Outsource\Models\OutsourceStaffChecklist;
use Hris\Outsource\Models\OutsourceStaffContract;
use Hris\Outsource\Models\OutsourceStaffs;
use Hris\Outsource\Requests\OutsourceStaffChecklistRequest;
use Hris\Outsource\Requests\OutsourceStaffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class OutsourceStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $outsource = Outsource::findOrFail($id);
        $query = OutsourceStaffs::query();
        $query->with(['checklist']);
        $filter = $this->filterQuery($query);
        $staffs = $filter->where('outsource_id', $outsource->id)
                ->orderBy('name')
                ->paginate(20)
                ->withQueryString();

        $datas['excel'] = Storage::exists('export/'.auth()->id().'/staff_project.xlsx') ? Storage::url('export/'.auth()->id().'/staff_project.xlsx'): '';
        $datas['import'] = asset('assets/outsource/import_staff.xlsx');
        return Inertia::render('Staff/Outsources/Staffs/Index', [
            'outsource' => $outsource,
            'staffs' => $staffs,
            'datas' => $datas,
            'statuss' => config('outsourceConstant.status'),
            'filters' => request()->only(['code', 'name', 'email', 'status', 'from', 'to'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $outsource = Outsource::findOrFail($id);
        return Inertia::render('Staff/Outsources/Staffs/Create', [
            'outsource' => $outsource,
            'status' => config('outsourceConstant.status')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutsourceStaffRequest $request, $id)
    {
        $outsource = Outsource::findOrFail($id);
        $assets = [];
        if($request->staff_asset)
        {
            foreach($request->staff_asset as $ast)
            {
                $assets[] = [
                    'asset_title' => $ast['asset_title'],
                    'asset_action' => $ast['asset_action']
                ];
            }
        }   
        $medicals = [];
        if($request->staff_medical)
        {
            foreach($request->staff_medical as $medical)
            {
                $medicals[] = [
                    'medical_type' => $medical['medical_type'],
                    'policy_number' => $medical['policy_number'],
                    'medical_from' => $medical['medical_from'],
                    'medical_to' => $medical['medical_to']
                ];
            }
        }  
        $documents = [];
        if($request->staff_document)
        {
            for($i=0, $iMax = count($request->staff_document); $i< $iMax; $i++)
			{
				if($request->hasfile('staff_document.'.$i.'.document_file'))
				{
					$file = $request->staff_document[$i]['document_file'];
					$documents[] = [
                        'document_label' => $request->staff_document[$i]['document_label'],
                        'document_file' => Storage::url($file->store('outsource/staffs/documents', 'public')),
                    ];
				}
			}
        }
        $outsource_staff = OutsourceStaffs::create([
            'outsource_id' => $outsource->id,
            'image' => $request->hasFile('profile_image') ? $request->file('profile_image')->store('outsource/staffs', 'public') : '',
            'asset_taken' => $assets,
            'medical' => $medicals,
            'documents' => $documents,
        ] + $request->validated());

        if($request->staff_contract)
        {
            foreach($request->staff_contract as $contract)
            {
                OutsourceStaffContract::create([
                    'outsource_staff_id' => $outsource_staff->id,
                    'position' => $contract['position'],
                    'salary' => $contract['salary'],
                    'contract_start' => $contract['contract_start'],
                    'contract_end' => $contract['contract_end'],
                    'current' => $contract['current'],
                ]);
            }
        }

        return redirect()->route('staffs.outsources.staffs.index', [$outsource->id])->with('success', 'Staff Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $staff_id)
    {
        $outsource = Outsource::findOrFail($id);
        $staff = OutsourceStaffs::with(['contract', 'checklist'])->where('outsource_id', $outsource->id)->where('id', $staff_id)->first();
        return Inertia::render('Staff/Outsources/Staffs/Show', [
            'outsource' => $outsource,
            'staff' => $staff,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $staff_id)
    {
        $outsource = Outsource::findOrFail($id);
        $staff = OutsourceStaffs::with('contract')->where('outsource_id', $outsource->id)->where('id', $staff_id)->first();

        return Inertia::render('Staff/Outsources/Staffs/Edit', [
            'outsource' => $outsource,
            'status' => config('outsourceConstant.status'),
            'staff' => $staff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OutsourceStaffRequest $request, $id, $staff_id)
    {
        $outsource = Outsource::findOrFail($id);
        $assets = [];
        if($request->staff_asset)
        {
            foreach($request->staff_asset as $ast)
            {
                $assets[] = [
                    'asset_title' => $ast['asset_title'],
                    'asset_action' => $ast['asset_action']
                ];
            }
        }   
        $medicals = [];
        if($request->staff_medical)
        {
            foreach($request->staff_medical as $medical)
            {
                $medicals[] = [
                    'medical_type' => $medical['medical_type'],
                    'policy_number' => $medical['policy_number'],
                    'medical_from' => $medical['medical_from'],
                    'medical_to' => $medical['medical_to']
                ];
            }
        }  
        $documents = [];
        if($request->staff_document)
        {
            for($i=0, $iMax = count($request->staff_document); $i< $iMax; $i++)
			{
				if($request->hasfile('staff_document.'.$i.'.document_file'))
				{
					$file = $request->staff_document[$i]['document_file'];
					$documents[] = [
                        'document_label' => $request->staff_document[$i]['document_label'],
                        'document_file' => Storage::url($file->store('outsource/staffs/documents', 'public')),
                    ];
				}else{
                    $documents[] = [
                        'document_label' => $request->staff_document[$i]['document_label'],
                        'document_file' => $request->staff_document[$i]['document_file'],
                    ];
                }
			}
        }
        $outsource_staff = OutsourceStaffs::where('outsource_id', $outsource->id)->where('id', $staff_id)->first();
        
        $profile_image = $outsource_staff->getRawOriginal('image');
        if($request->hasFile('profile_image'))
        {
            if(Storage::exists($profile_image))
                Storage::delete($profile_image);
            $profile_image = $request->file('profile_image')->store('outsource/staffs', 'public');
        }
        $outsource_staff->update([
            'image' => $profile_image,
            'asset_taken' => $assets,
            'medical' => $medicals,
            'documents' => $documents,
        ] + $request->validated());
        OutsourceStaffContract::where('outsource_staff_id', $outsource_staff->id)->delete();
        if($request->staff_contract)
        {
            foreach($request->staff_contract as $contract)
            {
                OutsourceStaffContract::create([
                    'outsource_staff_id' => $outsource_staff->id,
                    'position' => $contract['position'],
                    'salary' => $contract['salary'],
                    'contract_start' => $contract['contract_start'],
                    'contract_end' => $contract['contract_end'],
                    'current' => $contract['current'],
                ]);
            }
        }

        return redirect()->route('staffs.outsources.staffs.index', [$outsource->id])->with('success', 'Staff Added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $staff_id)
    {
        $outsource = Outsource::findOrFail($id);
        $outsource_staff = OutsourceStaffs::findOrFail($staff_id);
        $profile_image = $outsource_staff->getRawOriginal('image');
        if(Storage::exists($profile_image))
            Storage::delete($profile_image);
        $outsource_staff->delete();
        return back()->with('success', 'Staff Deleted');
    }

    public function saveChecklist(OutsourceStaffChecklistRequest $request, $id, $staff_id)
    {
        $outsource = Outsource::findOrFail($id);
        $outsource_staff = OutsourceStaffs::findOrFail($staff_id);
        OutsourceStaffChecklist::updateOrCreate([
            'outsource_staff_id' => $outsource_staff->id
        ], [
            'outsource_staff_id' => $outsource_staff->id,
        ]+ $request->validated());
        return back()->with('success', 'Outsource Staff Checklist Saved');
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
        if(request()->filled('code')) {
            $query->where('staff_code', 'LIKE', '%'.request()->code.'%');
        }
        if(request()->filled('name')) {
            $query->where('name', 'LIKE', '%'.request()->name.'%');
        }
        if(request()->filled('email')) {
            $query->where('email', 'LIKE', '%'.request()->email.'%');
        }
        if(request()->filled('from')) {
            $query->where('contract_start','<=', request()->from);
        }
        if(request()->filled('to')) {
            $query->where('contract_end','>=', request()->to);
        }
        if(request()->filled('status')) {
            $query->where('status', request()->status);
        }
        return $query;
    }

    public function export_staff($id)
    {
        $outsource = Outsource::findOrFail($id);
        $query = OutsourceStaffs::query();
        $query->with(['checklist', 'current_contract']);
        $filter = $this->filterQuery($query);
        $staffs = $filter->where('outsource_id', $outsource->id)
                ->orderBy('name')
                ->get()
                ->map(function($q){
                    $q->group_medical_insurance = $q->checklist ? $q->checklist->group_medical_insurance : '';
                    $q->group_accidental_insurance = $q->checklist ? $q->checklist->group_accidental_insurance : '';
                    $q->assets = $q->checklist ? $q->checklist->assets : '';
                    $q->id_card = $q->checklist ? $q->checklist->id_card : '';
                    $q->experience_letter = $q->checklist ? $q->checklist->experience_letter : '';
                    $q->salary_settlement = $q->checklist ? $q->checklist->salary_settlement : '';
                    $q->warning_letter = $q->checklist ? $q->checklist->warning_letter : '';
                    $q->pending_work = $q->checklist ? $q->checklist->pending_work : '';
                    $q->advance_payment = $q->checklist ? $q->checklist->advance_payment : '';
                    return $q;
                })
                ->toArray();
        (new OutsourceStaffExport($staffs))->store('export/'.auth()->id().'/staff_project.xlsx', 'public');
    }

    public function import_staff($id, Request $request)
	{
        $this->validate($request, [
            'outsource_importStaff' => 'required|max:2048|mimes:xls,xlsx'
        ]);
		$import = Excel::import(new OutSourceStaffImport($id), request()->file('outsource_importStaff'));
		if(!$import)
		{
			return back()->with('danger', 'Something Went Wrong!');
		}
		return back()->with('success', 'Outsource Project Staff Saved Successfully!');
	}
}
