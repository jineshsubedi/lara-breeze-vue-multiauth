<?php

namespace Hris\Event\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|max:150',
            'description' => 'required|max:2000',
            'docFile' => 'sometimes|nullable|mimes:docx,doc,pdf,csv,xlsx,xls|max:2048',
            'bannerFile' => 'sometimes|nullable|mimes:jpg,png,jpeg,webp,gif|max:2048',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'branch.*' => 'required'
        ];
    }
}
