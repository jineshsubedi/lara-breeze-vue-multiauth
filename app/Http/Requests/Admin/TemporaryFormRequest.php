<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TemporaryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'parent_id' => 'required',
            'f_lable' => 'required',
            'f_type' => 'required',
            'list_menu' => 'sometimes|nullable',
            'marks' => 'sometimes|nullable',
            'extra' => 'sometimes|nullable',    
            'required' => 'required|in:0,1',    
        ];
    }
}
