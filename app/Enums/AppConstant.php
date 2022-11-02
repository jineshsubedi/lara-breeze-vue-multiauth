<?php
namespace App\Enums;

class AppConstant
{
    const RATING_TIMES = [
        ['value' => 1, 'title' => 'Monthly'],
        ['value' => 2, 'title' => '3 Monthly'],
        ['value' => 3, 'title' => '6 Monthly'],
        ['value' => 4, 'title' => 'Yearly'],
    ];

    const YN = [
        ['value' => '0', 'title' => 'No'],
        ['value' => '1', 'title' => 'Yes']
    ];

    const LANG_DATE = [
        ['value' => 1, 'title' => 'Nepali Date'],
        ['value' => 2, 'title' => 'English Date']
    ];

    const DURATION = [
        ['value' => 1, 'title' => 'Real Time'],
        ['value' => 2, 'title' => 'Half Monthly'],
        ['value' => 3, 'title' => 'Monthly'],
        ['value' => 4, 'title' => '3 Monthly'],
        ['value' => 5, 'title' => '6 Monthly'],
        ['value' => 6, 'title' => 'Yearly']
    ];

    const CLIENT_RATING = [
        ['value' => 1, 'title' => 'Monthly'],
        ['value' => 2, 'title' => '3 Monthly'],
        ['value' => 3, 'title' => '6 Monthly'],
        ['value' => 4, 'title' => 'Yearly'],
        ['value' => 5, 'title' => 'Manually']
    ];

    const PERFORMANCE_TITLES = ['Task','KPIs','Discipline','Punctuality','Subordinate Rating', 'Achievement'];

    const GENDER = ['Male','Female', 'Other'];

    const MARITAL_STATUS = ['Married','Unmarried'];
}