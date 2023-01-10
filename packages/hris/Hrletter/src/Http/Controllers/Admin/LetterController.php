<?php

namespace Hris\Hrletter\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use Hris\Hrletter\Models\Letter;
use Hris\Hrletter\Models\LetterType;
use Hris\Hrletter\Requests\LetterRequest;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LetterController extends Controller
{
    protected $disk = 'public';
    protected $path = 'HrLetters';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return Inertia::render('Admin/Letters/Index', [
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
        return Inertia::render('Admin/Letters/Create',[
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
        return redirect()->route('admin.letters.index')->with('success', 'Record Added!');
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
        return Inertia::render('Admin/Letters/Edit', [
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
        return redirect()->route('admin.letters.index')->with('success', 'Record Updated');
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

}

