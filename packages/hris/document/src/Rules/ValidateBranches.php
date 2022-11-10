<?php

namespace Hris\Document\Rules;

use App\Models\Branch;
use Illuminate\Contracts\Validation\Rule;

class ValidateBranches implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $branches = Branch::pluck('id');

        foreach($value as $branch)
        {
            if(!in_array($branch,$branches->toArray())) {
                return false;
            }
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
        return 'Some of the selected branches is invalid';
    }
}
