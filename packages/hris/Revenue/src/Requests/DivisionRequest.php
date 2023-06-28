<?php

namespace Hris\Revenue\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionRequest extends FormRequest
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
                'category.*.title' => 'required|unique:divisions',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|unique:divisions,title,'.$this->division->id.',id',
            ];
        }

        return $rules;
    }
}
