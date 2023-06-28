<?php

use App\Enums\AppConstant;
use App\Enums\StaffType;
use Hris\Onboarding\Enums\OnboardStatus;

return [
    'status' => [
        OnboardStatus::ACCEPT->value, 
        OnboardStatus::REJECT->value, 
    ],
    'nature' => AppConstant::EMPLOYMENT_TYPE,
    'employment' => [
        'Temporary', 'Permananet'
    ],
    'trail' => AppConstant::YN,
    'staff_types' => [
        ['value' => StaffType::ADMIN->value, 'title' => 'Branch Admin'],
        ['value' => StaffType::SUPERVISOR->value, 'title' => 'Line Manager'],
        ['value' => StaffType::STAFF->value, 'title' => 'Employee']
    ]
];

?>