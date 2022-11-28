<?php

namespace App\Http\Requests\Admin;

use App\Enums\EmploymentType;
use App\Enums\StaffType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UsersRequest extends FormRequest
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
        $rules = [
            'name' => ['required','string','max:100'],
            'branch_id' => ['required','integer', 'gt:0'],
            'supervisor_id' => ['required','integer'],
            'staff_type' => ['required','integer'],
            'department_id' => ['required','integer'],
            'designation_id' => ['required','integer'],
            'shift_time_id' => ['required','integer'],
            'status' => ['required', new Enum(StaffType::class)],
            'join_date' => ['required','date', 'date_format:Y-m-d', 'before:tomorrow'],
            'weekend' => ['required'],
            'employment_type' => ['required', new Enum(EmploymentType::class)]
        ];
        
        if($this->getMethod() =='POST') {
            $rules += [
                'probation' => ['required'],
                'user_password' => ['required', 'string', 'min:6'],
                'confirm_password' => ['required', 'string', 'same:user_password'],
                'email' => ['required','email','max:80','unique:users,email'],
                'employee_code' => ['required','string','max:80','unique:users,employee_code'],
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'user_password' => ['sometimes', 'nullable', 'string', 'min:6'],
                'confirm_password' => ['sometimes', 'nullable', 'string', 'same:user_password'],
                'email' => ['required','email','max:80', Rule::unique('users')->ignore($this->user->id)],
                'employee_code' => ['required','string','max:80',Rule::unique('users')->ignore($this->user->id)],
            ];
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'supervisor_id.required' => 'Please Select Supervisor',
            'supervisor_id.integer' => 'Please Select Supervisor',
            'staff_type.required' => 'Please Select Staff Role',
            'staff_type.gt' => 'Please Select Staff Role',
            'department_id.required' => 'Please Select Department',
            'designation_id.required' => 'Please Select Designation',
            'shift_time_id.required' => 'Please Select Shift Time',
        ];
    }
}
