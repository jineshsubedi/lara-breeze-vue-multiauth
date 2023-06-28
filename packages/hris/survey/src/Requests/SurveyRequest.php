<?php

namespace Hris\Survey\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'status' => 'required|in:0,1',
            'description' => 'required|max:3000',
            'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date'
        ];
    }
}
