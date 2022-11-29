<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FiscalYearRequest extends FormRequest
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
        $rules = [
            'current_year' => ['required','integer'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date'],
        ];
        if($this->getMethod() =='POST') {
            $rules += [
                'title' => ['bail','required','string','max:80','unique:fiscal_years'],
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'title' => ['bail','required','string','max:80',Rule::unique('fiscal_years')->ignore($this->fiscalyear->id)],
            ];
        }

        return $rules;
    }
}
