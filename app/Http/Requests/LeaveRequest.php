<?php

namespace App\Http\Requests;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Rules\HandoverRule;
use App\Rules\LeaveDateRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'leave_type_id' => ['required', 'integer', Rule::in(LeaveType::pluck('id'))],
            'document' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:5120'],
            'compensation' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'type' => ['required', 'integer', Rule::in(Leave::getLeaveNatures())],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', new LeaveDateRule(request()->start_date)],
            'duration' => ['required', 'integer'],
            'contact_no' => ['required'],
            'description' => ['required', 'string', 'max:255'],
            'documentFile' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'handover_staff' => [new HandoverRule(request()->handover_staff)]
        ];
    }
}
