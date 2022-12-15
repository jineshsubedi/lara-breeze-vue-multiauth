<?php
namespace App\Enums;

use App\Models\User;

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

    const ALLOW = [
        ['value' => 0, 'title' => 'Deny'],
        ['value' => 1, 'title' => 'Allow']
    ];

    const REQUIRED = [
        ['value' => 0, 'title' => 'Optional'],
        ['value' => 1, 'title' => 'Required']
    ];

    const NEPALI_MONTH = [
        ['id' => 1, 'title' => 'बैशाख'],
        ['id' => 2, 'title' => 'जेठ'],
        ['id' => 3, 'title' => 'आषाढ़'],
        ['id' => 4, 'title' => 'श्रावण'],
        ['id' => 5, 'title' => 'भाद्र'],
        ['id' => 6, 'title' => 'असोज'],
        ['id' => 7, 'title' => 'कार्तिक'],
        ['id' => 8, 'title' => 'मंसिर'],
        ['id' => 9, 'title' => 'पुष'],
        ['id' => 10, 'title' => 'माघ'],
        ['id' => 11, 'title' => 'फाल्गुन'],
        ['id' => 12, 'title' => 'चैत्र'],
    ];

    const ENGLISH_MONTH = [
        ['id' => 1, 'title' => 'January'],
        ['id' => 2, 'title' => 'February'],
        ['id' => 3, 'title' => 'March'],
        ['id' => 4, 'title' => 'April'],
        ['id' => 5, 'title' => 'May'],
        ['id' => 6, 'title' => 'June'],
        ['id' => 7, 'title' => 'July'],
        ['id' => 8, 'title' => 'August'],
        ['id' => 9, 'title' => 'September'],
        ['id' => 10, 'title' => 'October'],
        ['id' => 11, 'title' => 'November'],
        ['id' => 12, 'title' => 'December'],
    ];

    const WEEK = [
        'SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'
    ];

    const NEPALIDATE = 1;
    const ENGLISHDATE = 2;

    const WORKDURATION = 8;
    const LOCATION = '27.6905941,85.3275142';

    const ATTENDANCE_STATUS = [
        ['value' => 0, 'title' => 'Pending'],
        ['value' => 1, 'title' => 'Approved'],
    ];

    const USER_STATUS = [
        ['value' => User::CURRENTLY_WORKING, 'title' => 'Working'],
        ['value' => User::RESIGNED, 'title' => 'Resigned'],
        ['value' => User::TERMINATED, 'title' => 'Terminated'],
        ['value' => User::ABSCONDING, 'title' => 'Absconding'],
    ];

    const EMPLOYMENT_TYPE = [
        'Full Time', 'Part Time', 'Contract'
    ];

    const COMPENSATORY_STATUS = [
        ['value' => '1', 'title' => 'Approved'],
        ['value' => '2', 'title' => 'Canceled']
    ];

    const FORM_TYPE = [
        ['value' => 'text', 'title' => 'Text'],
        ['value' => 'select', 'title' => 'Select'],
        ['value' => 'textarea', 'title' => 'Textarea'],
        ['value' => 'radio', 'title' => 'Radio'],
        ['value' => 'checkbox', 'title' => 'Checkbox'],
        ['value' => 'email', 'title' => 'Email'],
        ['value' => 'date', 'title' => 'Date'],
        ['value' => 'file', 'title' => 'File'],
    ];

}