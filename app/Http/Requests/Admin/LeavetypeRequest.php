<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LeavetypeRequest extends FormRequest
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
        $rules = [];

        if($this->getMethod() =='POST') {
            $rules += [
                'branch_id' => 'required|integer',
                'leave_type.*.title' => 'required|unique:leave_type',
                'leave_type.*.days' => 'required|integer',
                'leave_type.*.apply_before' => 'required|integer',
                'leave_type.*.eligible' => 'required|integer',
                'leave_type.*.continuous' => 'required|integer',
                'leave_type.*.accrual' => 'required|integer',
                'leave_type.*.accrual_basis' => 'required|integer',
                'leave_type.*.is_extra' => 'sometimes|nullable|integer',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|unique:leave_type',
                'days' => 'required|integer',
                'apply_before' => 'required|integer',
                'eligible' => 'required|integer',
                'continuous' => 'required|integer',
                'accrual' => 'required|integer',
                'accrual_basis' => 'required|integer',
                'is_extra' => 'sometimes|nullable|integer',
            ];
        }

        return $rules;
    }
}
