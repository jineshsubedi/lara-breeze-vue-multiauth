<?php

namespace Hris\Survey\Observers;

use Hris\Survey\Models\Survey;

class SurveyObserver
{
    public function creating(Survey $survey)
    {
        $survey->branch_id = auth()->user()->branch_id;
    }
}
