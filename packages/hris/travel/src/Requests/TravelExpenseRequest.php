<?php

namespace Hris\Travel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelExpenseRequest extends FormRequest
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
            'destination_id' => 'required',
            'type' => 'required',
            'ticket' => 'sometimes',
            'lodging' => 'sometimes',
            'breakfast' => 'sometimes',
            'lunch' => 'sometimes',
            'dinner' => 'sometimes',
            'phone' => 'sometimes',
            'local_conveyance' => 'sometimes',
            'others' => 'sometimes',
        ];
    }
}
