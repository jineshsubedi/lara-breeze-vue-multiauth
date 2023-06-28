<?php

namespace Hris\Suggestion\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionRequest extends FormRequest
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
        $rules = [];

        if($this->getMethod() =='POST') {
            $rules += [
                'suggestion_for_id' => 'required|integer',
                'hide_name' => 'required|integer',
                'description' => 'required|max:2000',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'description' => 'required|max:1000',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'suggestion_for_id.required' => 'suggestion category is required'
        ];
    }
}
