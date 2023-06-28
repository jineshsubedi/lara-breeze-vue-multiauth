<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KpiRatingRequest extends FormRequest
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
            'staff' => 'required|integer',
            'quality' => 'required',
            'communication' => 'required',
            'consistency' => 'required',
            'independent' => 'required',
            'proactiviness' => 'required',
            'creativity' => 'required',
        ];
    }
}
