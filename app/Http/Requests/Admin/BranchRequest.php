<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\District;
use App\Models\Province;

class BranchRequest extends FormRequest
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
            'description' => ['nullable','string','max:255'],
            'province_id' => ['required','integer', Rule::in(Province::pluck('id'))],
            'district_id' => ['required','integer', Rule::in(District::pluck('id'))],
            'is_head' => ['required','integer'],
            'login_ip' => ['nullable','string'],
        ];

        if($this->getMethod() =='POST') {
            $rules += [
                'name' => ['bail','required','string','max:80','unique:branches'],
                'email' => ['bail','required','string','max:80','unique:branches'],
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                     'name' => ['bail','required','string','max:80',Rule::unique('branches')->ignore($this->branch->id)],
                     'email' => ['bail','required','string','max:80',Rule::unique('branches')->ignore($this->branch->id)],
                ];
            }

        return $rules;
    }
}
