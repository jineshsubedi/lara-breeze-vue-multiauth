<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LeaveSettingRequest extends FormRequest
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
            'branch_id' => ['required','integer'],
            'quarter_day' => ['required','integer'],
            'half_day' => ['required','integer'],
            'sandwich' => ['required','integer'],
            'handover' => ['required','integer'],
            's_approval' => ['nullable','integer'],
            'h_approval' => ['nullable','integer'],
            'm_approval' => ['nullable','integer'],
            'accrual_basis' => ['required','integer'],
            'hr_person' => ['nullable','integer'],
            'm_person' => ['nullable','integer'],
            'leave_handler' => ['nullable','integer'],
            'maximum_leave' => ['required','integer'],
        ];
    }
    public function messages()
    {
        return [
            // 'hr_person.gt' => 'Please Select Staff',
            // 'm_person.gt' => 'Please Select Staff',
            // 'leave_handler.gt' => 'Please Select Staff',
        ];
    }
}
