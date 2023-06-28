<?php

namespace Hris\Travel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentCategoryRequest extends FormRequest
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
                'category.*.title' => 'required|unique:assignment_categories',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|unique:assignment_categories,title,'.$this->assignmentcategory->id.',id',
            ];
        }

        return $rules;
    }
}
