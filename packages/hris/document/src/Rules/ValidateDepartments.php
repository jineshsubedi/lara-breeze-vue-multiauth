<?php

namespace Hris\Document\Rules;

use App\Models\Department;
use Illuminate\Contracts\Validation\Rule;

class ValidateDepartments implements Rule
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
        $departments = Department::pluck('id');

        foreach($departments as $department)
        {
            if(!in_array($department,$value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
         return 'Some of the selected department is invalid';
    }
}
