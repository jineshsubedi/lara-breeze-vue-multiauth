<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobLevelRequest extends FormRequest
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
                'category.*.name' => 'required|unique:job_levels',
                'category.*.order' => 'required|integer',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'name' => 'required|unique:job_levels,name,'.$this->joblevel->id.',id',
                'order' => 'required|integer'
            ];
        }

        return $rules;
    }
}
