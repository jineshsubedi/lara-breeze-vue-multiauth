<?php

namespace Hris\Travel\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Travel\Models\Travel;
use Hris\Travel\Models\TravelExpense;
use Hris\Travel\Requests\TravelApprovalRequest;
use Hris\Travel\Requests\TravelExpenseRequest;
use Illuminate\Http\Request;

class TravelExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveTravelExpense(TravelExpenseRequest $request, $id)
    {
        $travel = Travel::findOrFail($id);
        TravelExpense::create([
            'travel_id' => $travel->id
        ] + $request->validated());
        return back()->with('success', 'Travel Expenses Added');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTravelExpense($id)
    {
        TravelExpense::findOrFail($id)->delete();
        return back()->with('success', 'Travel Expense Deleted');
    }

    public function approveTravelExpense(TravelApprovalRequest $request, $id, $expense_id)
    {
        return $request->all();
        $travel = Travel::findOrFail($id);
        $expense = TravelExpense::findOrFail($expense_id);
        if($travel->id != $expense->travel_id)
        {
            return back()->with('danger', 'Travel Cannot be Updated');
        }
        $approval_types = ['supervisor', 'account', 'hr', 'manager'];
        $approval_data = [
            'supervisor' => [
                'approval' => 'supervisor_approval',
                'remark' => 'supervisor_remark'
            ],
            'account' => [
                'approval' => 'account_approval',
                'remark' => 'account_remark'
            ],
            'hr' => [
                'approval' => 'hr_approval',
                'remark' => 'hr_remark'
            ],
            'manager' => [
                'approval' => 'chairman_approval',
                'remark' => 'chairman_remark'
            ],
        ];

        if(in_array($request->type, $approval_types)) {
            $expense->update([
                $approval_data[$request->type]['approval'] => $request->status,
                $approval_data[$request->type]['remark'] => $request->remarks
            ]);
        }

        return back()->with('success', 'Travel Expense Approval Request Updated');
    }
}
