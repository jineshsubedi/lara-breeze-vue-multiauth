<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Models\Branch;
use App\Models\Notice;
use Inertia\Inertia;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::branchList();
        $query = Notice::query();
        $query->with(['branch:id,name']);
        $filter = $this->filterQuery($query);
        $notices = $filter->latest('id', 'desc')->paginate(15)->withQueryString();
        return Inertia::render('Admin/Notices/Index', [
            'notices' => $notices,
            'branches' => $branches,
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
        return Inertia::render('Admin/Notices/Create',[
            'branches' => $branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeRequest $request)
    {
        Notice::create($request->validated());
        return redirect()->route('admin.notices.index')->with('success', 'Notice Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return Inertia::render('Admin/Notices/Show', [
            'notice' => $notice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        return Inertia::render('Admin/Notices/Edit', [
            'notice' => $notice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoticeRequest $request, Notice $notice)
    {
        $notice->update($request->validated());
        return redirect()->route('admin.notices.index')->with('success', 'Notice Added Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
        return back()->with('success', 'Notice Deleted!');
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
        return $query;
    }
}
