<?php

namespace Hris\Overtime\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvertimereasonRequest extends FormRequest
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
                'category.*.title' => 'required|unique:overtimereasons',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required|unique:overtimereasons,title,'.$this->overtimereason->id.',id',
            ];
        }

        return $rules;
    }
}