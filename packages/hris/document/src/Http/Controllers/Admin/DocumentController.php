<?php

namespace Hris\Document\Http\Controllers\Admin;

use Hris\Document\Requests\DocumentRequest;
use App\Http\Controllers\Controller;
use Hris\Document\Models\Document;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DocumentController extends Controller
{
    protected $disk = 'public';
    protected $path = 'documents';

    public function index(Request $request)
    {
        $query = Document::query();
        $filter = $this->filterQuery($query);
        $documents = $filter->latest('id')->paginate(20)->withQueryString();
        return Inertia::render('Admin/Document/Index', [
            'documents' => $documents,
            'filters' => $request->only(['branch_id'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::branchList();
        $departments = Department::with('branch:id,name')->branchList()->orderBy('branch_id')->get(['id', 'title', 'branch_id']);
        return Inertia::render('Admin/Document/Create',[
            'branches' => $branches,
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        Document::create($request->validated() + [
            'document' => $request->file('docfile')->store($this->path, $this->disk)
        ]);
        return redirect()->route('admin.documents.index')->with('success', 'Document Added Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        $branches = Branch::branchList();
        $departments = Department::with('branch:id,name')->branchList()->orderBy('branch_id')->get(['id', 'title', 'branch_id']);
        return Inertia::render('Admin/Document/Edit', [
            'document' => $document,
            'branches' => $branches,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, Document $document)
    {
        $document_path = $document->getRawOriginal('document');
        if($request->hasFile('docfile'))
        {
            if(Storage::exists($document_path))
                Storage::delete($document_path);
            $document_path = $request->file('docfile')->store($this->path, $this->disk);
        }
        $document->update($request->validated() + [
            'document' => $document_path
        ]); 
        return redirect()->route('admin.documents.index')->with('success', 'Document Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $document_path = $document->getRawOriginal('document');
        if(Storage::exists($document_path))
            Storage::delete($document_path);
        $document->delete();
        return back()->with('success', 'Document Deleted Successfully!');
    }

    private function filterQuery($query)
    {
        if(request()->filled('branch')) {
            $query->whereIn('branch_id', request()->branch);
        }
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->whereIn('branch_id', auth()->user()->branch_id);
        }
        return $query;
    }
}
