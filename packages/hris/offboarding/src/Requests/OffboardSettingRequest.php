<?php

namespace Hris\Offboarding\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffboardSettingRequest extends FormRequest
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
            'branch_id' => 'required',
    		'retirement' => 'required',
    		'retirement_alert' => 'required',
    		'retraction' => 'required',
        ];
    }
}
