<?php

namespace Hris\Adjustment\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdjustmentRequest extends FormRequest
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
            'login_time' => 'required',
            'logout_time' => 'required',
            'adjustment_reason_id' => 'required',
            'time_to_be_adjusted' => 'required',
            'informed_to' => 'required',
            'remarks' => 'required',
            'login_date' => 'required|date|date_format:Y-m-d|before:tommorrow',
        ];
    }
}
