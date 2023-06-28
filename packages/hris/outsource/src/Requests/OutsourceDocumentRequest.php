<?php

namespace Hris\Outsource\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutsourceDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
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
            'title' => 'required|max:100',
            'type' => 'required',
            'attachment' => 'required|max:2048|mimes:png,jpg,jpeg,webp,gif,docx,doc,pdf,xlsx,xls'
        ];
    }
}
