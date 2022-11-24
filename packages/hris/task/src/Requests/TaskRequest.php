<?php

namespace Hris\Task\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        $rules = [
            'description' => ['nullable','string','max:2000'],
            'title' => ['required','string', 'max:100'],
            'task_to' => ['required','integer'],
            'kra_id' => ['required','integer'],
            'weightage' => ['required','numeric', 'between:1,10'],
            'finish_time' => ['required','date', 'date_format:Y-m-d'],
            'num_task' => ['required','integer'],
            'project' => ['required','string'],
            'personal' => ['required','integer'],
            'priority' => ['required','integer'],
            'branch_id' => ['required','integer'],
        ];

        if($this->getMethod() =='POST') {
            $rules += [
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
            ];
        }

        return $rules;
    }
}
