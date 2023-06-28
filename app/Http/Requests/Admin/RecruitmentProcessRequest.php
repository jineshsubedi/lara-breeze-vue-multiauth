<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RecruitmentProcessRequest extends FormRequest
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
            'description' => 'sometimes|nullable'
        ];

        if($this->getMethod() =='POST') {
            $rules += [
                'title' => 'required|max:100|unique:recruitment_processes',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|max:100|unique:recruitment_processes,title,'.$this->recruitmentprocess->id.',id',
            ];
        }

        return $rules;
    }
}
