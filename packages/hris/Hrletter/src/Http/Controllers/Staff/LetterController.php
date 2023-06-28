<?php

namespace Hris\Hrletter\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Setting;
use App\Models\User;
use Hris\Hrletter\Models\Letter;
use Hris\Hrletter\Models\LetterType;
use Hris\Hrletter\Requests\LetterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use PDF;

class LetterController extends Controller
{
    protected $disk = 'public';
    protected $path = 'HrLetters';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role:HrHandler');
    }
    public function index()
    {
        $query = Letter::query();
        $query->with(['branch:id,name','handler:id,name', 'department:id,title', 'type:id,title']);
        $filter = $this->filterQuery($query);
        $letters = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        $departments = Department::query();
        if(request()->filled('branch')) {
            $departments = $departments->where('branch_id', request()->branch)->get(['id', 'title']);
        }else{
            $departments = $departments->where('branch_id', auth()->user()->branch_id)->get(['id', 'title']);
        }
        return Inertia::render('Staff/Letters/Index', [
            'letters' => $letters,
            'departments' => $departments,
            'branches' => Branch::branchList(),
            'types' => LetterType::orderBy('title')->get(['id', 'title']),
            'filters' => request()->only(['type', 'branch', 'department'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Letters/Create',[
            'types' => LetterType::orderBy('title')->get(['id', 'title']),
            'branches' => Branch::branchList(),
            'defBranch' => auth()->user()->branch_id,
            'templates' => config('letterConstant.templates')
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Letter\LetterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LetterRequest $request)
    {
        Letter::create($request->validated() + [
            'signature' => $request->file('signatureFile')->store($this->path, $this->disk)
        ]);
        return redirect()->route('staffs.letters.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LetterRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function edit(Letter $letter)
    {
        return Inertia::render('Staff/Letters/Edit', [
            'letter' => $letter,
            'types' => LetterType::orderBy('title')->get(['id', 'title']),
            'branches' => Branch::branchList(),
        ]);
    }

    public function update(LetterRequest $request, Letter $letter)
    {
        $document_path = $letter->signature;
        if($request->hasFile('signatureFile'))
        {
            if(Storage::exists($document_path))
                Storage::delete($document_path);
            $document_path = $request->file('signatureFile')->store($this->path, $this->disk);
        }
        $letter->update($request->validated() + [
            'signature' => $document_path
        ]); 
        $letter->update($request->validated());
        return redirect()->route('staffs.letters.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Letter $letter)
    {
        if($letter->signature != '' && Storage::exists($letter->signature))
            Storage::delete($letter->signature);
        $letter->delete();
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
        if(request()->filled('department')) {
            $query->where('department_id', request()->department);
        }
        if(request()->filled('type')) {
            $query->where('letter_type_id', request()->type);
        }
        if(request()->filled('handler')) {
            $query->where('handler', request()->handler);
        }
        return $query;
    }

    public function generate()
    {
        $user = auth()->user();
        return Inertia::render('Staff/Letters/Generate', [
            'letters' => Letter::with(['type:id,title'])->where('branch_id', $user->branch_id)->where('department_id', $user->department_id)->get(),
            'staffs' => User::active()->where('branch_id', $user->branch_id)->get(['id', 'name'])
        ]);
    }
    public function letter_generation(Request $request)
    {
        $this->validate($request, [
            'staff_id' => 'required',
            'letter_id' => 'required',
        ]);
        $letter = Letter::with(['type:id,title'])->findOrFail($request->letter_id);
        $handler = User::with(['designation:id,title'])->select('id', 'name', 'designation_id')->find($letter->handler);
        $description = $letter->description;
        $letterTitle = $letter->type ? $letter->type->title : 'Letter Type';
        $user = User::select('id', 'name', 'email', 'gender')->findOrFail($request->staff_id);
        $setting = Setting::first();

        $description = str_replace(
            [
                '*letter-type*', 
                '*today*',
                '*employee-name*',
                '*title*',

                '*signature*',
                '*stamp*',
                '*letter-handler*',
                '*letter-handler-designation*',

                '*employer-name*',
                '*employer-address*'
            ], 
            [
                $letterTitle,
                date('d M, Y'),
                $user->name,
                $user->gender == 'Male' ? 'Mr.' : ($user->gender == 'Female' ? 'Mrs.' : ''),

                $letter->signature_path ? '<img src="'.$letter->signature_path.'" style="width: 100px;"/>' : '',
                '<img src="/images/stamp.png" style="width:100px; position: absolute; bottom: 80px; opacity: .7; left: 100px;" />',

                $handler->name,
                $handler->designation ? $handler->designation->title : '',

                $setting->name,
                $setting->address
            ], 
            $description
        );

        return $description;
    }

}

