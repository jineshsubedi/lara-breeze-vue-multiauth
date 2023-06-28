<?php

namespace Hris\Offboarding\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetractionRequest extends FormRequest
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
            'resignation_staffs_id' => 'required',
            'description' => 'required|max:500',
            'work_commitment' => 'required',
            'retraction_reason' => 'required'
        ];
    }
}
