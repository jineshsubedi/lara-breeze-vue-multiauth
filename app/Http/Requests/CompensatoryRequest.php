<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompensatoryRequest extends FormRequest
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
            'work_day' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'reason' => 'required|max:200',
            'inform_to' => 'required|integer',
        ];
    }
}
