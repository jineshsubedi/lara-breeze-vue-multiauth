<?php

namespace Hris\Travel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentTypeRequest extends FormRequest
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
                'category.*.title' => 'required|unique:assignment_types',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|unique:assignment_types,title,'.$this->assignmenttype->id.',id',
            ];
        }

        return $rules;
    }
}
