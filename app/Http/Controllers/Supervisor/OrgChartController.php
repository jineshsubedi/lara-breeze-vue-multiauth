<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrgChartController extends Controller
{
    public function index(Request $request)
    {
        $query = User::active();
        $query->with(['supervisor:id,name', 'designation:id,title']);
        $filter = $this->filterQuery($query);
        $users = $filter->get(['id', 'name', 'supervisor_id', 'designation_id']);
        $chartDatas = [];
        foreach($users as $user)
        {
            $d = $user->designation ? '('.$user->designation->title.')' : '';
            $f = $user->name.'<div style="color: #'.rand(000, 999).';">'.$d.'</div>';
            $chartDatas[] = [
                [
                    'f' => $f,
                    'v' => $user->name,
                ],
                $user->supervisor ? $user->supervisor->name : '',
                $user->designation ? $user->designation->title : '',
            ];
        }
        return Inertia::render('Supervisor/Orgchart',[
            'chartDatas' => $chartDatas,
            'branches' => Branch::branchList(),
            'filters' => $request->only(['branch'])
        ]);
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
