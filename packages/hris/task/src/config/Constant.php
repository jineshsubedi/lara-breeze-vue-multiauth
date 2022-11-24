<?php

use App\Enums\AppConstant;

return [

    'parent_type' => [
        ['value' => 1, 'title' => 'Task'],
        ['value' => 2, 'title' => 'Job'],
    ],
    'task_ownership' => AppConstant::YN,
    'task_status' => [
        ['value' => 1, 'title' => 'Completed'],
        ['value' => 2, 'title' => 'Not Completed']
    ],
    'task_priority' => [
        ['value' => '1', 'title' => 'Low Priority'],
        ['value' => '2', 'title' => 'Medium Priority'],
        ['value' => '3', 'title' => 'High Priority'],
        ['value' => '4', 'title' => 'Highest Priority'],
        ['value' => '5', 'title' => 'Non Priority']
    ]
];