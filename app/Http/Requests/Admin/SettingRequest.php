<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'sometimes|nullable|string',
            'logo' => 'sometimes|nullable|string',
            'icon' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'item_perpage' => 'sometimes|nullable|integer',
            'description_limit' => 'sometimes|nullable|integer',
            'latitude' => 'sometimes|nullable|string',
            'longitude' => 'sometimes|nullable|string',
            'meta_title' => 'sometimes|nullable|string',
            'meta_keyword' => 'sometimes|nullable|string',
            'meta_description' => 'sometimes|nullable|string',
            'google_analytics' => 'sometimes|nullable|string',

            'protocal' => 'sometimes|nullable|string',
            'parameter' => 'sometimes|nullable|string',
            'host_name' => 'sometimes|nullable|string',
            'username' => 'sometimes|nullable|string',
            'password' => 'sometimes|nullable|string',
            'smtp_port' => 'sometimes|nullable|string',
            'encryption' => 'sometimes|nullable|string',

            'socials.*.name' => 'sometimes|nullable|string',
            'socials.*.icon' => 'sometimes|nullable|string',
            'socials.*.url' => 'sometimes|nullable|string',
        ];
    }
}
