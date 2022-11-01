<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BranchRequest;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Branch;
use App\Models\User;
use Inertia\Inertia;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Branch::query();
        $query->with(['province:id,title','district:id,title']);
        $filter = $this->filterQuery($query);
        $branches = $filter->latest('id')->paginate(15);
        $provinces = Province::titleList();
        $districts = District::when($request->province, function($q){
            return $q->where('province_id', request('province'));
        })->titleList();

        return Inertia::render('Admin/Branch/Index', [
            'branches' => $branches,
            'provinces' => $provinces,
            'districts' => $districts,
            'filters' => $request->only(['province', 'district'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::titleList();
        $yn = AppConstant::YN;
        $rating_times = AppConstant::RATING_TIMES;

        return Inertia::render('Admin/Branch/Create', [
            'provinces' => $provinces,
            'yn' => $yn,
            'rating_times' => $rating_times,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        Branch::create($request->validated());
        return redirect()->route('admin.branches.index')->with('success', 'Branch Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $provinces = Province::titleList();
        $yn = AppConstant::YN;
        $rating_times = AppConstant::RATING_TIMES;
        return Inertia::render('Admin/Branch/Edit', [
            'branch' => $branch,
            'provinces' => $provinces,
            'yn' => $yn,
            'rating_times' => $rating_times,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());
        return redirect()->route('admin.branches.index')->with('success', 'Branch Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        if ($branch->is_head == 1)
        {
            return back()->with('danger', 'Branch Cannot be Deleted Successfully!');
        }
        $branch->delete();
        return back()->with('success', 'Branch Deleted Successfully!');
    }

    private function filterQuery($query)
    {
        if(request()->filled('province')) {
             $query->where('province_id', request()->province);
        }
        if(request()->filled('district')) {
            $query->where('district_id', request()->district);
        }
        return $query;
    }
}
