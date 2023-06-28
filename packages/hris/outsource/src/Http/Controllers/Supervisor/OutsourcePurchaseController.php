<?php

namespace Hris\Outsource\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Hris\Outsource\Models\Outsource;
use Hris\Outsource\Models\OutSourcePurchaseOrder;
use Hris\Outsource\Requests\OutsourcePurchaseRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OutsourcePurchaseController extends Controller
{
    public function index($id)
    {
        $outsource = Outsource::findOrFail($id);
        $outsource->load(['purchase' => function($q){
            $q->with(['department:id,title']);
        }]);
        return Inertia::render('Supervisor/Outsources/Purchase', [
            'outsource' => $outsource,
            'departments' => Department::where('branch_id', auth()->user()->branch_id)->get(['id', 'title'])
        ]);
    }

    public function store($id, OutsourcePurchaseRequest $request)
    {
        $outsource = Outsource::findOrFail($id);
        OutSourcePurchaseOrder::create([
            'outsource_id' => $outsource->id
        ] + $request->validated());
        return back()->with('success', 'Purchase Order Added');
    }

    public function destroy($id, $purchase_id)
    {
        OutSourcePurchaseOrder::findOrFail($purchase_id)->delete();
        return back()->with('success', 'Purchase Order Deleted');
    }
}
