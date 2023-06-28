<?php

namespace Hris\Attendance\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateAttendanceRequest extends FormRequest
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
            'staff' => 'required|integer',
            'year' => 'required|integer',
            'month' => 'required|integer',
            'start_day' => 'required|integer',
            'end_day' => 'required|integer',
            'in_time' => 'required|date_format:H:i',
            'out_time' => 'required|date_format:H:i',
            'manual' => 'required|integer',
            'remarks' => 'required|string|max:200',
        ];
    }
}
