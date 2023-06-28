<?php

namespace Hris\Document\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Hris\Document\Rules\ValidateBranches;
use Hris\Document\Rules\ValidateDepartments;

class DocumentRequest extends FormRequest
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
            'title' => ['bail','required','string','max:255'],
            'description' => ['nullable','string','max:2000'],
            'docfile' => ['nullable','mimes:pdf,doc,docx,xls,jpg,png,jpeg,csv','max:5120'],
            'branch_id' => ['nullable','array', new ValidateBranches],
            'department_id' => ['nullable','array',new ValidateDepartments]
         ];
         return $rules;
    }
}
