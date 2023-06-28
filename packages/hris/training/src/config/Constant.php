<?php

return [
    'types' => [
        ['id' => 1, 'title' => 'Per Training'], 
        ['id'=> 2, 'title'=>'Per Hour']
    ],
    'answer_options' => [
        ['title' => 'Very Unsatisfied', 'value' => 1],
        ['title' => 'Unsatisfied ', 'value' => 2],
        ['title' => 'Neutral', 'value' => 3],
        ['title' => 'Satisfied ', 'value' => 4],
        ['title' => 'VerySatisfied', 'value' => 5],
    ],
    'level' => [
        ['title' => 'Begineer', 'value' => 1],
        ['title' => 'Intermediate', 'value' => 2],
        ['title' => 'Advanced', 'value' => 3],
        ['title' => 'Master', 'value' => 4],
    ],
    'status' => [
        ['title' => 'draft', 'value' => 0],
        ['title' => 'Active', 'value' => 1],
        ['title' => 'Inactive', 'value' => 2],
    ],
    'share' => [
        ['title' => 'Both', 'value' => 0],
        ['title' => 'Trainer', 'value' => 1],
        ['title' => 'Trainee', 'value' => 2],
    ],
    'form_type' => [
        ['title' => 'Text', 'value' => 'text'],
        ['title' => 'Multi-Score', 'value' => 'multiple'],
        ['title' => 'Select', 'value' => 'select'],
        ['title' => 'Date', 'value' => 'date'],
        ['title' => 'Email', 'value' => 'email'],
        ['title' => 'Radio', 'value' => 'radio'],
        ['title' => 'Checkbox', 'value' => 'checkbox'],
        ['title' => 'Textarea', 'value' => 'textarea'],
        ['title' => 'File', 'value' => 'file'],
    ]
];

?>