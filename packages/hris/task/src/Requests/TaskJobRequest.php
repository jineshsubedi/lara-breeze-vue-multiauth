<?php

namespace Hris\Task\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskJobRequest extends FormRequest
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
            'description' => ['nullable','string','max:2000'],
            'title' => ['required','string', 'max:100'],
            'end_date' => ['required','date', 'date_format:Y-m-d'],
            'priority' => ['required','integer'],
            'imageFile' => ['nullable','mimes:jpg,png,jpeg,gif','max:5120'],
        ];
    }
}
