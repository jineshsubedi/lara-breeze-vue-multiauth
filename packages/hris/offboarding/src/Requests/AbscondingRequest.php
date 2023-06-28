<?php

namespace Hris\Offboarding\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbscondingRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'issued_date' => 'required|date',
            'action' => 'required|integer',
            'description' => 'required|max:1000',

            'previous_action' => 'sometimes|nullable',
            'suspension_days' => 'sometimes',
            'penalty_charge' => 'sometimes',
            'follow_up_medium' => 'sometimes|nullable|integer',
            'follow_up_description' => 'sometimes|nullable|max:500',
            'follow_up_attachmentFile' => 'sometimes|nullable|max:2048|mimes:png,jpg,jpeg,docx,pdf,doc',
        ];
        if (request()->input('action_type') == 1) {
            $rules['suspension_days'] = 'required';
        }
        else{
            $rules['penalty_charge'] = 'required';
        }
        return $rules;
    }
}
