<?php

return [
    'type' => ['domestic', 'international'],
    'level' => [
        ['title' => 'Begineer', 'value' => 1],
        ['title' => 'Intermediate', 'value' => 2],
        ['title' => 'Advanced', 'value' => 3],
        ['title' => 'Master', 'value' => 4],
    ],
    'grade' => [
        ['title' => 'Grade One', 'value' => 1],
        ['title' => 'Grade Two', 'value' => 2],
        ['title' => 'Grade Three', 'value' => 3],
        ['title' => 'Grade Four', 'value' => 4],
    ],
    'mode_of_transport' => ['road', 'air'],
    'road_sub' => [
        ['title' => 'Self-Owned Vehicle', 'value' => 1],
        ['title' => 'Company-Owned Vehicle', 'value' => 2],
        ['title' => 'Rental Vehicle', 'value' => 3],
    ],
    'payment_mode' => [
        ['title' => 'Reimbursement Mode', 'value' => 1],
        ['title' => 'Pre Diem Reimbursement', 'value' => 2],
    ],
    'reimbursement' => [
        ['title' => 'Pre-Paid 70%', 'value' => 1],
        ['title' => 'Post-Paid 30%', 'value' => 2],
    ],
    'approval' => [
        ['title' => 'Approve', 'value' => 1],
        ['title' => 'Reject', 'value' => 2],
    ]
];

?>