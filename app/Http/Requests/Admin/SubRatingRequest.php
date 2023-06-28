<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubRatingRequest extends FormRequest
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
            'supervisory' => 'required',
            'quality' => 'required',
            'communication' => 'required',
            'consistency' => 'required',
            'independent' => 'required',
            'proactiveness' => 'required',
            'creativity' => 'required',
            'leadership' => 'required',
            'supervisory_detail' => 'sometimes|nullable|max:500',
            'leadership_detail' => 'sometimes|nullable|max:500',
            'quality_detail' => 'sometimes|nullable|max:500',
            'communication_detail' => 'sometimes|nullable|max:500',
            'consistency_detail' => 'sometimes|nullable|max:500',
            'independent_detail' => 'sometimes|nullable|max:500',
            'proactiveness_detail' => 'sometimes|nullable|max:500',
            'creativity_detail' => 'sometimes|nullable|max:500',
        ];
    }
}
