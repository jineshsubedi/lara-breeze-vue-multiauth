<?php

use Hris\Newsfeed\Enums\NewsfeedEvent;

return [
    'event_category' => [
        ['title' => 'Birthday', 'value' => NewsfeedEvent::BIRTHDAY->value],
        ['title' => 'Anniversary', 'value' => NewsfeedEvent::ANNIVERSARY->value],
        ['title' => 'Achievement', 'value' => NewsfeedEvent::ACHIEVEMENT->value],
        ['title' => 'Promotion', 'value' => NewsfeedEvent::PROMOTION->value],
        ['title' => 'Marriage', 'value' => NewsfeedEvent::MARRIAGE->value],
    ],
];

?>