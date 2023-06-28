<?php

namespace Hris\Offboarding\Requests;

use Hris\Offboarding\Enums\ResignationStatus;
use Illuminate\Foundation\Http\FormRequest;

class ResignationApprovalRequest extends FormRequest
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
            'resignation_id' => 'required|integer',
            'supervisor_approval_status' => 'required|in:'.ResignationStatus::APPROVED->value.','.ResignationStatus::REJECTED->value,
            'supervisor_approval_detail' => 'required|max:500',
            'type' => 'required|in:supervisor,hr',
            'offBoarding_date' => 'sometimes|nullable'
        ];
        if (request()->input('type') == 'hr' && request()->input('supervisor_approval_status') == ResignationStatus::APPROVED->value) {
            $rules['offBoarding_date'] = 'required|date|date_format:Y-m-d';
        }

        return $rules;
    }
}
