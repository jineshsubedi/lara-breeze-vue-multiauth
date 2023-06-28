<?php

namespace Hris\Training\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingTemplateRequest extends FormRequest
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
            'training_id' => 'required|integer',
            'title' => 'required',
            'description' => 'required|max:500',
            'share_with' => 'required|integer',
            'schedule' => 'required|in:0,1',
            'schedule_date' => 'sometimes|nullable|date|date_format:Y-m-d',
            'schedule_end_date' => 'sometimes|nullable|date|date_format:Y-m-d|after_or_equal:schedule_date',
        ];
    }
}
