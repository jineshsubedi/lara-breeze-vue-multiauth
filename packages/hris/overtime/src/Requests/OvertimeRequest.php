<?php

namespace Hris\Overtime\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeRequest extends FormRequest
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
            'overtime_reason_id' => 'required',
            'ot_hour' => 'required',
            'holiday' => 'required',
            'remarks' => 'required',
            'login_date' => 'required|date|date_format:Y-m-d|before:tommorrow',
        ];
    }
}
