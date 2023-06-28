<?php

use Hris\Offboarding\Enums\OffboardActionType;
use Hris\Offboarding\Enums\ResignationStatus;
use Hris\Offboarding\Enums\TerminationStatus;

return [
    'action_types' => [
        ['title' => 'Suspension', 'value' => OffboardActionType::SUSPENSION->value],
        ['title' => 'Penalty', 'value' => OffboardActionType::PENALTY->value],
    ],
    'actions' => [
        ['title' => '1st Warning', 'value' => 1],
        ['title' => '2nd Warning', 'value' => 2],
        ['title' => '3rd Warning', 'value' => 3],
    ],
    'termination_status' => [
        TerminationStatus::UNPROCESS->value,
        TerminationStatus::TERMINATE->value,
        TerminationStatus::HIRE->value
    ],
    'resignation_status' => [
        ResignationStatus::APPROVED->value,
        ResignationStatus::REJECTED->value,
    ],
    'retraction_status' => [
        ['value' => 1, 'title' => 'New Terms of Employment']
    ]
];

?>