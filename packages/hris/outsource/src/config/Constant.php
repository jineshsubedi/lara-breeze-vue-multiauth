<?php

use Hris\Outsource\Enums\OutSourceStatus;

return [
    'status' => [
        OutSourceStatus::ACTIVE->value, 
        OutSourceStatus::INACTIVE->value, 
        OutSourceStatus::HOLD->value, 
        OutSourceStatus::TERMINATE->value, 
        OutSourceStatus::COMPLETED->value, 
    ],
    'types' => [
        ['id'=>1,'title'=>'Contract Sample'],
        ['id'=>2,'title'=>'Appointment Sample'],
        ['id'=>3,'title'=>'Salary Statement Letter'],
        ['id'=>4,'title'=>'Warning Letter'],
        ['id'=>5,'title'=>'ID card Sample'],
        ['id'=>6,'title'=>'Experience Letter'],
        ['id'=>7,'title'=>'Termination Letter '],
        ['id'=>8,'title'=>'Updated Salary Breakdown']
    ]
];

?>