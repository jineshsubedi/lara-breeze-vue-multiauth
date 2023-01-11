<?php

namespace Hris\Training\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingProgramRequest extends FormRequest
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
        $rules = [];

        if($this->getMethod() =='POST') {
            $rules += [
                'category.*.title' => 'required|unique:training_programs',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|unique:training_programs,title,'.$this->trainingprogram->id.',id',
            ];
        }

        return $rules;
    }
}
