<?php

namespace Hris\Revenue\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RevenueRequest extends FormRequest
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
                'revenue.*.revenue' => 'required',
                'revenue.*.division_id' => 'required',
                'revenue.*.direct_expenses' => 'required',
                'revenue.*.indirect_expenses' => 'required',
                'revenue.*.net_profit' => 'required',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'revenue' => 'required',
                'division_id' => 'required',
                'direct_expenses' => 'required',
                'indirect_expenses' => 'required',
                'net_profit' => 'required',
            ];
        }

        return $rules;
    }
}
