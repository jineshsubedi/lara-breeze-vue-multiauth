<?php

namespace Hris\Outsource\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Outsource\Models\Outsource;
use Hris\Outsource\Models\OutSourceDocument;
use Hris\Outsource\Requests\OutsourceDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OutsourceDocumentController extends Controller
{
    protected $disk = 'public';
    protected $path = 'outsource/documents';

    public function index($id)
    {
        $outsource = Outsource::findOrFail($id);
        $outsource->load(['documents']);
        return Inertia::render('Admin/Outsources/Document', [
            'outsource' => $outsource,
            'types' => config('outsourceConstant.types')
        ]);
    }

    public function store($id, OutsourceDocumentRequest $request)
    {
        OutSourceDocument::create([
            'outsource_id' => $id,
            'file_name' => $request->file('attachment')->store($this->path, $this->disk)
        ] + $request->validated());

        return back()->with('success', 'Document Added');
    }

    public function destroy($id, $doc_id)
    {
        // $outsource = Outsource::findOrFail($id);
        $doc = OutSourceDocument::findOrFail($doc_id);
        if($doc->file_name != '')
        {
            if(Storage::exists($doc->file_name))
                Storage::delete($doc->file_name);
        }
        $doc->delete();
        return back()->with('success', 'Document Deleted');
    }
}
