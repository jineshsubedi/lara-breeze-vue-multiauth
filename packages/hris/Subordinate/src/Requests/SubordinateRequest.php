<?php

namespace Hris\Subordinate\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubordinateRequest extends FormRequest
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
            'comment' => 'required|max:2000',
            'rating' => 'required|integer|min:1|max:10'
        ];
    }
}
