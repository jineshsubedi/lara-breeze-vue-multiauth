<?php

namespace Hris\Offboarding\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffboardProcessRequest extends FormRequest
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
                'department_id' => 'required|integer',
                'category.*.title' => 'required|unique:offboard_processes',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'department_id' => 'required|integer',
                'title' => 'required|unique:offboard_processes,title,'.$this->offboardprocess->id.',id',
            ];
        }

        return $rules;
    }
}
