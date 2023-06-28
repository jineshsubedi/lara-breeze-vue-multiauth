<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
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
            'title' => 'required',
            'seo_url' => 'required',
            'branch_id' => 'required|integer',
            'job_level' => 'required',
            'job_availability' => 'required',
            'min_experience' => 'required',
            'position' => 'sometimes',
            'vacancy_code' => 'required',
            'deadline' => 'required',
            'salary_unit' => 'required',
            'negotiable' => 'required|in:0,1',
            'gender' => 'required',
            'min_age' => 'required',
            'max_age' => 'required',
            'apply_type' => 'required',
            'setting' => 'required',
            'process_status' => 'required',
            'status' => 'required',
            'publish_date' => 'required',
            'sort_order' => 'required|integer',
            'job_location.*' => 'sometimes|nullable',
            'external_link' => 'sometimes|nullable',
            'minimum_salary' => 'sometimes|nullable',
            'emails' => 'sometimes|nullable',
            'line_manager' => 'sometimes',
            'assignment_handeler' => 'sometimes',
            'jobFile' => 'sometimes|nullable|mimes:docx,pdf,png,jpg,jpeg,webp|max:2048',
            'advertise_detail' => 'sometimes',
            'advertise_link' => 'sometimes',
            'image' => 'sometimes',

            'formfields.*' => 'required',
            'location_title' => 'required',
            'manual_education' => 'sometimes',
            'education_levels.*' => 'sometimes',
            'edu_marks' => 'sometimes',
            'exp_marks' => 'sometimes',
        ];

        return $rules;
    }
}
