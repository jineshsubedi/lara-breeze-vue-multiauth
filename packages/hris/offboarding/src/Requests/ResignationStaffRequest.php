<?php

namespace Hris\Offboarding\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResignationStaffRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'resignation_reason_id' => 'required|integer',
            'resignation_type_id' => 'required|integer',
            'resignation_detail' => 'required|max:500',
        ];
    }
}
