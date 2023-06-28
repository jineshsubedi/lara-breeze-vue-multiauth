<?php

namespace App\Rules;

use App\Models\LeaveSetting;
use Illuminate\Contracts\Validation\Rule;

class HandoverRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($handover)
    {
        $this->handover = $handover;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $setting = LeaveSetting::where('branch_id', auth()->user()->branch_id)->first();
        if(!isset($setting->id))
        {
            return true;
        }
        if($setting->handover == 1)
        {
            if($this->handover > 0) {
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You must select one staff to handover';
    }
}
