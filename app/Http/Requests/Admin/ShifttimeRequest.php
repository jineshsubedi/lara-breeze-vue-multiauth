<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShifttimeRequest extends FormRequest
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
                'branch_id' => 'required|integer',
                'shift_time.*.title' => 'required|min:3',
                'shift_time.*.start_time' => 'required|date_format:H:i',
                'shift_time.*.end_time' => 'required|date_format:H:i',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => 'required',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s|after:start_time',
            ];
        }

        return $rules;
    }
}
