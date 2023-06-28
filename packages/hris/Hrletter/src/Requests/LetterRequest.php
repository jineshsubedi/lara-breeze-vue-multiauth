<?php

namespace Hris\Hrletter\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LetterRequest extends FormRequest
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
        return [
            'branch_id' => 'required|integer',
            'letter_type_id' => 'required|integer',
            'description' => 'required|max:5000',
            'department_id' => 'required|integer',
            'handler' => 'required|integer',
            'signatureFile' => 'sometimes|nullable|mimes:jpg,png,jpeg,webp,gif|max:2048'
        ];
    }
}
