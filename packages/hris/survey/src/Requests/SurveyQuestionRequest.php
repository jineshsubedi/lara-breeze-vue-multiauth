<?php

namespace Hris\Survey\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyQuestionRequest extends FormRequest
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
            'parent_id' => 'sometimes|nullable|integer',
            'label' => 'required',
            'type' => 'required|in:text,email,select,textarea,radio,file,checkbox,date',
            'list_menu' => 'sometimes',
            'required' => 'required',
            'extra' => 'sometimes',
            'sort' => 'required|integer',
        ];
    }
}
