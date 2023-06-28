<?php

namespace Hris\Hrletter\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LetterTypeRequest extends FormRequest
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
                'category.*.title' => 'required|unique:letter_types',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|unique:letter_types,title,'.$this->lettertype->id.',id',
            ];
        }

        return $rules;
    }
}
