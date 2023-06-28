<?php

namespace Hris\Training\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
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
            'training_program_id' => 'sometimes|integer',
            'trainer_id' => 'required|integer',
            'status' => 'required|integer',
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d',
            'level' => 'required',
            'budget' => 'required',
            'venue' => 'sometimes',
            'total_participant' => 'required',

            'notice_date' => 'required|date|date_format:Y-m-d',
            'submit_date' => 'required|date|date_format:Y-m-d',
            'description' => 'required|max:2000',
            'documentFile' => 'sometimes|nullable|mimes:doc,docx,pdf|max:2048',

            'category.itinery_date' => 'sometimes|nullable|date|date_format:Y-m-d',
            'category.topic' => 'sometimes|nullable',
            'category.start_time' => 'sometimes|nullable|date_format:H:i',
            'category.end_time' => 'sometimes|nullable|date_format:H:i',
            'category.duration' => 'sometimes|nullable',
        ];
    }
}
