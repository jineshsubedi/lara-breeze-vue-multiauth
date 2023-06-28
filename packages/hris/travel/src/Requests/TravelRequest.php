<?php

namespace Hris\Travel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelRequest extends FormRequest
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
            'type' => 'required|in:domestic,international',
            'assigned_to' => 'required|integer',
            'from' => 'required',
            'to' => 'required',
            'purpose' => 'required',
            'assignment_type' => 'required',
            'assignment_category' => 'required',
            'mode_of_transport' => 'required',
            'advance_required' => 'required',

            'account_name' => 'sometimes',
            'account_number' => 'sometimes',
            'bank_name' => 'sometimes',

            'payment_mode' => 'sometimes',
            'road_sub' => 'sometimes',
            'reimbursement' => 'sometimes',
            'position' => 'sometimes',
            'grade' => 'sometimes',
            'per_diem_amount' => 'sometimes',
        ];
        if ($this->attributes->has('advance_required') == 1) {
            $rules['payment_mode'] = 'required';
        }
        if ($this->attributes->has('mode_of_transport') == 'road') {
            $rules['road_sub'] = 'required';
        }
        if ($this->attributes->has('payment_mode') == 1) {
            $rules['reimbursement'] = 'required';
        }
        if ($this->attributes->has('payment_mode') == 2) {
            $rules['position'] = 'required';
            $rules['grade'] = 'required';
            $rules['per_diem_amount'] = 'required';    
        }

        return $rules;
    }
}
