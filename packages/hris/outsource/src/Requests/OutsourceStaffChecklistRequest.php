<?php

namespace Hris\Outsource\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutsourceStaffChecklistRequest extends FormRequest
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
            'group_medical_insurance' => 'required',
            'group_accidental_insurance' => 'required',
            'assets' => 'required',
            'id_card' => 'required',
            'experience_letter' => 'required',
            'salary_settlement' => 'required',
            'warning_letter' => 'required',
            'pending_work' => 'required',
            'advance_payment' => 'required',
        ];
    }
}
