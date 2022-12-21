<?php

namespace Hris\Interview\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExitInterviewRequest extends FormRequest
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
            'interview_date' => 'required|date',
            'service_tenure' => 'required|date',
            'received_by' => 'required|integer',
            'description.*.question' => 'required',
            'description.*.answer' => 'required',
        ];
    }
}
