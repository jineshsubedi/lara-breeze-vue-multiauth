<?php

namespace App\Http\Controllers\Staff;

use App\Http\Requests\Admin\UsersRequest;
use App\Http\Controllers\Controller;
use App\Enums\EmploymentType;
use Illuminate\Http\Request;
use App\Enums\AppConstant;
use App\Enums\StaffType;
use App\Models\Branch;
use App\Models\User;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:HrHandler|StaffHandler');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::branchList();
        $query = User::query();
        $query->with(['branch:id,name']);
        $filter = $this->filterQuery($query);
        $users = $filter->latest('id')->paginate(30)->withQueryString();
        $datas['status'] = AppConstant::USER_STATUS;
        $datas['types'] = AppConstant::EMPLOYMENT_TYPE;

        return Inertia::render('Staff/Users/Index', [
            'users' => $users,
            'branches' => $branches,
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
        return Inertia::render('Staff/Users/Create',[
            'datas' => $datas,
        ]);
    }
    private function getData()
    {
        $data['branches'] = Branch::branchList();
        $data['defBranch'] = auth()->user()->branch_id;
        $data['weekend'] = AppConstant::WEEK;
        $data['types'] = [EmploymentType::FULL->value, EmploymentType::PART->value, EmploymentType::CONTRACT->value];
        $data['status'] = AppConstant::USER_STATUS;
        $data['staff_type'][] = ['value' => StaffType::ADMIN->value, 'title' => 'Branch Admin'];
        $data['staff_type'][] = ['value' => StaffType::SUPERVISOR->value, 'title' => 'Line Manager'];
        $data['staff_type'][] = ['value' => StaffType::STAFF->value, 'title' => 'Employee'];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $user = User::create($request->validated() + [
            'password' => bcrypt($request->user_password)
        ]);
        return redirect()->route('staffs.users.index')->with('success', 'User Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user->roles;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $datas = $this->getData();
        return Inertia::render('Staff/Users/Edit', [
            'user' => $user,
            'datas' => $datas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('staffs.users.index')->with('success', 'User Detail Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User Deleted Successfully!');
    }

    private function filterQuery($query)
    {
        if(request()->filled('branch')) {
            $query->where('branch_id', request()->branch);
        }
        if(request()->filled('name')) {
            $query->where('name', 'LIKE', '%'.request()->name.'%');
        }
        if(request()->filled('type')) {
            $query->where('employment_type', request()->type);
        }
        if(request()->filled('status')) {
            $query->where('status', request()->status);
        }
        return $query;
    }
}
