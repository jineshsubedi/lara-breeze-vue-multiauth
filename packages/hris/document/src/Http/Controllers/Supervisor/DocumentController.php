<?php

namespace Hris\Document\Http\Controllers\Supervisor;

use Hris\Document\Requests\DocumentRequest;
use App\Http\Controllers\Controller;
use Hris\Document\Models\Document;
use Illuminate\Http\Request;
use App\Models\Branch;
use Inertia\Inertia;

class DocumentController extends Controller
{
    protected $disk = 'public';
    protected $path = 'documents';

    public function index(Request $request)
    {
        $query = Document::query();
        $query->with(['branch:id,name']);
        $filter = $this->filterQuery($query);
        $documents = $filter->latest('id')->paginate(15);
        return Inertia::render('Supervisor/Document/Index', [
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
        return Inertia::render('Supervisor/Document/Create',[
            'branches' => $branches
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
            'document' => $request->file('document')->store($this->path, $this->disk)
        ]);
        return redirect()->route('supervisor.documents.index')->with('success', 'Document Added Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return Inertia::render('Supervisor/Document/Edit', [
            'document' => $document
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
        $document_path = $document->document;
        if($request->hasFile('document'))
        {
            $this->deleteFile($document);
            $document_path = $request->file('document')->store($this->path, $this->disk);
        }
        $document->update($request->validated() + [
            'document' => $document_path
        ]);
        return redirect()->route('supervisor.documents.index')->with('success', 'Document Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $document->delete();
        return back()->with('success', 'Document Deleted Successfully!');
    }

    private function filterQuery($query)
    {
        if(request()->filled('branch')) {
            $query->where('branch_id', request()->branch);
        }
        return $query;
    }
}
