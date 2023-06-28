<?php

namespace Hris\Booking\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'place_id' => 'required|integer',
            'hall_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'booking_date' => 'required|date|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'required|max:2000',
            'staffs.*' => 'required|integer'
        ];
    }
}
