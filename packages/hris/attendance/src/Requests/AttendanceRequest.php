<?php

namespace Hris\Attendance\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'in_time_reason' => 'sometimes|nullable|string|max:500',
            'out_time_reason' => 'sometimes|nullable|string|max:500',
            'in_away_location' => 'sometimes|nullable|string|max:500',
            'out_away_location' => 'sometimes|nullable|string|max:500',
        ];
    }
}
