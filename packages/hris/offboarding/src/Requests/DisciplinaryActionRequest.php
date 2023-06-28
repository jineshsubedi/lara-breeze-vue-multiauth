<?php

namespace Hris\Offboarding\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaryActionRequest extends FormRequest
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
            'disciplinary_ground_id' => 'required|integer',
            'issued_date' => 'required|date',
            'justification_required' => 'required|in:0,1',
            'action' => 'required|integer',
            'description' => 'required|max:1000',

            'previous_action' => 'sometimes|nullable',
            'justification_deadline' => 'sometimes|nullable|date',
            'suspension_days' => 'sometimes',
            'penalty_charge' => 'sometimes',
        ];
        if (request()->input('justification_required') == 1) {
            $rules['justification_deadline'] = 'required|date';
        }
        if (request()->input('action_type') == 1) {
            $rules['suspension_days'] = 'required';
        }
        else{
            $rules['penalty_charge'] = 'required';
        }
        return $rules;
    }
}
