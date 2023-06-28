<?php

namespace Hris\Travel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelApprovalRequest extends FormRequest
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
            'travel_id' => 'required',
            'remarks' => 'required|max:200',
            'status' => 'required|in:1,2',
            'type' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'travel_id.required' => 'Travel Undefined',
            'type.required' => 'Undefined User Access',
        ];
    }
}
