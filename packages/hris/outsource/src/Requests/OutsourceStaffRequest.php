<?php

namespace Hris\Outsource\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutsourceStaffRequest extends FormRequest
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
			'name' => 'required',
			'staff_code' => 'required',
			'phone_number' => 'sometimes',
			'email' => 'required',
			'status' => 'required',
			'contract_start' => 'required|date|date_format:Y-m-d',
			'contract_end' => 'required|date|date_format:Y-m-d|after_or_equal:contract_start',
			'sex' => 'sometimes',
			'join_date' => 'required|date',
            
			'age' => 'sometimes',
			'dob' => 'sometimes|nullable|date',
			'department' => 'sometimes',
			'designation' => 'sometimes',
			'temporary_address' => 'sometimes',
			'citizenship' => 'sometimes',
			'pan_number' => 'sometimes',
			'ssf_number' => 'sometimes',
			'profile_image' => 'sometimes|nullable|mimes:jpg,png,jpeg,webp|max:2048',
			'education' => 'sometimes',
			'account_name' => 'sometimes',
			'account_number' => 'sometimes',
			'cit_number' => 'sometimes',
			'emergency_name' => 'sometimes',
			'emergency_relation' => 'sometimes',
			'emergency_number' => 'sometimes',
			'emergency_other_number' => 'sometimes',
        ];
    }
}
