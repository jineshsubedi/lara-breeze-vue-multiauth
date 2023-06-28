<?php

namespace Hris\Travel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelPlannerRequest extends FormRequest
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
            'user_id' => 'sometimes',
            'department_id' => 'sometimes',
            'itinery.*' => 'sometimes',
            'road.*' => 'sometimes',
            'air.*' => 'sometimes',
            'hotel.*' => 'sometimes',
        ];
    }
}
