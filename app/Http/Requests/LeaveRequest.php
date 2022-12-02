<?php

namespace App\Http\Requests;

use App\Models\Leave;
use App\Models\LeaveSetting;
use App\Models\LeaveType;
use App\Rules\LeaveDateRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(LeaveType $leaveType, LeaveSetting $leaveSetting)
    {
        $leaveType = $leaveType->find(request()->leave_type_id);
        $field = $leaveType->is_extra ?? null;
        $applyBefore = $leaveType->apply_before ?? 0;
        return [
            'leave_type_id' => ['required', 'integer', Rule::in(LeaveType::pluck('id'))],
            'document' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:5120'],
            'compensation' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'type' => ['required', 'integer', Rule::in(Leave::getLeaveNatures())],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', new LeaveDateRule(request()->start_date)],
            'contact_no' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'documentFile' => ['required', 'mimes:jpg,png,jpeg', 'max:2048'],
        ];
    }
}
