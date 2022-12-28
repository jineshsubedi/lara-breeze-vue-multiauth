<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
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
                'education_id' => 'required|integer',
                'category.*.title' => 'required|unique:faculties',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'education_id' => 'required|integer',
                'title' => 'required|unique:faculties,title,'.$this->faculty->id.',id',
            ];
        }

        return $rules;
    }
}
