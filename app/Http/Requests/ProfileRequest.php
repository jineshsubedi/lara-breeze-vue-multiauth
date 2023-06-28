<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'gender' => ['required','string'],
            'marital_status' => ['required','string'],
            'phone_number' => ['required','string'],
            'pdistrict_id' => ['required','integer'],
            'p_address' => ['required','string'],
            'dob' => ['required', 'date', 'date_format:Y-m-d','before:today'],
            'document.*.title' => [Rule::requiredIf(request()->document), 'string'],
            'document.*.document' => [Rule::requiredIf(request()->document), 'max:5120', 'mimes:pdf,docx,doc,xls,xlsx,jpg,png,jpeg'],
        ];
    }
    public function messages()
    {
        return [
            'document.*.title.required' => 'Title Must be required',
            'document.*.title.string' => 'Title Must be string',
            'document.*.document.required' => 'Document File Must be required',
            'document.*.document.max' => 'File maximum file size is 5120 KB',
            'document.*.document.mimes' => 'Required File format is pdf,docx,doc,xls,xlsx,jpg,png,jpeg',
        ];
    }
}
