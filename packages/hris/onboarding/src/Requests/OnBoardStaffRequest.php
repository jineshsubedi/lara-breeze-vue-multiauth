<?php

namespace Hris\Onboarding\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnBoardStaffRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string',
            'letter_type' => 'sometimes|nullable|integer',
            'staff_type' => 'required',
            'trail_period' => 'required',
            'supervisor_id' => 'required', 
            'department_id' => 'required', 
            'designation_id' => 'required', 
            'letter_type' => 'sometimes',
            'cvFile' => 'sometimes|nullable|mimes:doc,docx,pdf|max:2048',
            'nature_of_employment' => 'required',
            'nature_of_job' => 'required',
            'offer_letter'=> 'sometimes|nullable',
            'letter_accept_date' => 'sometimes|nullable',
            'salary' => 'sometimes|nullable',
            'level' => 'sometimes|nullable',
        ];
        if (request()->input('trail_period') == 1) {
            $rules['no_of_days'] = 'required';
            $rules['trail_start_date'] = 'required';
        }else{
            $rules['joining_date'] = 'required';
        }

        return $rules;
    }
}
