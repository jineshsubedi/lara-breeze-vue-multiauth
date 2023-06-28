<?php

namespace Hris\Booking\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingHallRequest extends FormRequest
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
                'place_id' => 'required|integer',
                'category.*.title' => 'required|unique:booking_places',
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'booking_place_id' => 'required|integer',
                'title' => 'required|unique:booking_places,title,'.$this->bookinghall->id.',id',
            ];
        }

        return $rules;
    }
}
