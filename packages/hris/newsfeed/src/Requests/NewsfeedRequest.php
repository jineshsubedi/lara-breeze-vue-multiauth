<?php

namespace Hris\Newsfeed\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsfeedRequest extends FormRequest
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
            'description' => 'required|max:2000',
            'imageFile' => 'sometimes|nullable',
            'video' => 'sometimes|nullable'
        ];

        if (request()->hasFile('imageFile')) {
            $rules['imageFile'] = 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048';
            $rules['description'] = 'sometimes|nullable';
        }
        if(request()->input('video'))
        {
            $rules['description'] = 'sometimes|nullable';
        }

        return $rules;
    }
}
