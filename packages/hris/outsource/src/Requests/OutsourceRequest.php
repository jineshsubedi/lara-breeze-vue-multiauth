<?php

namespace Hris\Outsource\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutsourceRequest extends FormRequest
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
            'project_name' => 'required',
			'client_name' => 'required',
			'contract_start' => 'required|date|date_format:Y-m-d',
			'contract_end' => 'required|date|date_format:Y-m-d|after:contract_start',
			'manager' => 'required',
			'supervisor' => 'required',
			'status' => 'required',
        ];
    }
}
