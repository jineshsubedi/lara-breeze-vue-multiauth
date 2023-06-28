<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            
            'title' => 'required',
            'department_head' => 'sometimes|nullable|integer',
            'minimum_leave' => 'required|integer',
            'maximum_leave' => 'required|integer',
        ];

        if($this->getMethod() =='POST') {
            $rules += [
                'branch_id' => 'required|integer',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                
            ];
        }

        return $rules;
    }
}
