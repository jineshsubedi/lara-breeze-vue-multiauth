<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
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
            'title' => ['required','string','max:100'],
            'department_id' => ['required','integer'],
        ];
        if($this->getMethod() =='POST') {
            $rules += [
                'document' => ['required','file','mimes:doc,docx,pdf', 'max:2048'],
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'document' => ['sometimes', 'nullable','file','mimes:doc,docx,pdf', 'max:2048'],
            ];
        }

        return $rules;
    }
}
