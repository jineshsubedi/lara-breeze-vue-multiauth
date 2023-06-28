<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchSettingRequest extends FormRequest
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
            'revenue' => 'sometimes|nullable',
            'client' => 'sometimes|nullable',
            'canteen' => 'sometimes|nullable',
            'attendance_handler' => 'required|integer',
            'hr_handler' => 'required|integer',
            'staff_handler' => 'required|integer',
            'training_handler' => 'required|integer',
            'survey_handler' => 'required|integer',
            'account_handler_signature' => 'required|string',
            'account_handler' => 'required|integer',
            'salary_calculate' => 'required|integer',
            'client_comment' => 'required|integer',
            'comment_type' => 'sometimes|nullable|integer',
            'performance_rater' => 'required|integer',
            'performance_rating_type' => 'required|integer',
            'out_source_handler' => 'sometimes|nullable',
            'client_comment' => 'sometimes|nullable',
            'comment_type' => 'sometimes|nullable'
        ];
    }
}
