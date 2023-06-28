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

   

    const GENDER = ['Male','Female', 'Other'];
    const PGENDER = ['Male','Female', 'Any'];

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

    const EXIT_INTERVIEW_QUESTION = [
        [ 
            'question' => 'What was your main reason for leaving the organization or the job?',
            'answer' => '',
        ],
        [ 
            'question' => 'What was the quality of the supervision you received? Your thoughts about your immediate supervisors?',
            'answer' => '',
        ],
        [ 
            'question' => 'Did any company policy or procedure make your job more difficult?',
            'answer' => '',
        ],
        [ 
            'question' => 'Did your job turn into what was described to you during the job interview process and induction?',
            'answer' => '',
        ],
        [ 
            'question' => 'Did you receive adequate support to do your job?',
            'answer' => '',
        ],
        [ 
            'question' => 'Your thoughts about the management?',
            'answer' => '',
        ],
        [ 
            'question' => 'What did you like most about working for this organization?',
            'answer' => '',
        ],
        [ 
            'question' => 'What did you like least about working for this organization?',
            'answer' => '',
        ],
        [ 
            'question' => 'What, if anything, could have been done to keep you with the company?',
            'answer' => '',
        ],
        [ 
            'question' => 'Provided a chance to change few things in the organization, what would that be?',
            'answer' => '',
        ],
        [
            'question' => 'Would you recommend others to work for this company?',
            'answer' => '',
        ]
    ];

    const MARK_SYSTEM = ['percentage','gpa'];

    const COMMUNICATION = [
        ['value' => '1', 'title' => 'Facebook'],
        ['value' => '2', 'title' => 'Website'],
        ['value' => '3', 'title' => 'Chat'],
        ['value' => '4', 'title' => 'Viber'],
        ['value' => '5', 'title' => 'Whatsapp'],
        ['value' => '6', 'title' => 'Phone'],
        ['value' => '7', 'title' => 'Other'],
    ];

    const JOB_AVAILABILITY = [
        'Full Time', 'Part Time', 'Contract'
    ];

    const MIN_EXPERIENCE = [
        ['value' => 1, 'title' => '1 year'],
        ['value' => 2, 'title' => '2 year'],
        ['value' => 3, 'title' => '3 year'],
        ['value' => 4, 'title' => '4 year'],
        ['value' => 5, 'title' => '5 year'],
        ['value' => 6, 'title' => '6 year'],
        ['value' => 7, 'title' => '7 year'],
        ['value' => 8, 'title' => '8 year'],
        ['value' => 9, 'title' => '9 year'],
        ['value' => 10, 'title' => '10 year'],
        ['value' => 11, 'title' => '11 year'],
        ['value' => 12, 'title' => '12 year'],
        ['value' => 13, 'title' => '13 year'],
        ['value' => 14, 'title' => '14 year'],
        ['value' => 15, 'title' => '15 year'],
    ];

    const WORK_EXPERIENCE = [
        ['value' => 18, 'title' => '18 year'],
        ['value' => 19, 'title' => '19 year'],
        ['value' => 20, 'title' => '20 year'],
        ['value' => 21, 'title' => '21 year'],
        ['value' => 22, 'title' => '22 year'],
        ['value' => 23, 'title' => '23 year'],
        ['value' => 24, 'title' => '24 year'],
        ['value' => 25, 'title' => '25 year'],
        ['value' => 26, 'title' => '26 year'],
        ['value' => 27, 'title' => '27 year'],
        ['value' => 28, 'title' => '28 year'],
        ['value' => 29, 'title' => '29 year'],
        ['value' => 30, 'title' => '30 year'],
        ['value' => 31, 'title' => '31 year'],
        ['value' => 32, 'title' => '32 year'],
        ['value' => 33, 'title' => '33 year'],
        ['value' => 34, 'title' => '34 year'],
        ['value' => 35, 'title' => '35 year'],
        ['value' => 36, 'title' => '36 year'],
        ['value' => 37, 'title' => '37 year'],
        ['value' => 38, 'title' => '38 year'],
        ['value' => 39, 'title' => '39 year'],
        ['value' => 40, 'title' => '40 year'],
        ['value' => 41, 'title' => '41 year'],
        ['value' => 42, 'title' => '42 year'],
        ['value' => 43, 'title' => '43 year'],
        ['value' => 44, 'title' => '44 year'],
        ['value' => 45, 'title' => '45 year'],
        ['value' => 46, 'title' => '46 year'],
        ['value' => 47, 'title' => '47 year'],
        ['value' => 48, 'title' => '48 year'],
        ['value' => 49, 'title' => '49 year'],
    ];

    const JOB_SETTING = [
        ['value' => '1', 'title' => 'Online Apply'],
        ['value' => '2', 'title' => 'Email Apply'],
        ['value' => '3', 'title' => 'Post Apply'],
        ['value' => '4', 'title' => 'Online & Email Apply'],
    ];

    const JOB_STATUS = [
        ['value' => '0', 'title' => 'Draft'],
        ['value' => '1', 'title' => 'Active'],
        ['value' => '2', 'title' => 'Disabled'],
    ];

    const JOB_FORMFIELDS = [
        ['value' => 'saluation', 'title' => 'Saluation'],
        // ['value' => 'first_name', 'title' => 'First Name'],
        // ['value' => 'middle_name', 'title' => 'Middle Name'],
        // ['value' => 'last_name', 'title' => 'Last Name'],
        ['value' => 'gender', 'title' => 'Gender'],
        ['value' => 'marital_status', 'title' => 'Marital Status'],
        ['value' => 'permanent_address', 'title' => 'Permanent Address'],
        ['value' => 'temporary_address', 'title' => 'Temporary Address'],
        ['value' => 'home_phone', 'title' => 'Home Phone'],
        // ['value' => 'mobile_phone', 'title' => 'Mobile Phone'],
        // ['value' => 'email', 'title' => 'E-mail'],
        ['value' => 'citizenship', 'title' => 'Citizenship No'],
        ['value' => 'fax', 'title' => 'Fax'],
        ['value' => 'website', 'title' => 'Website'],
        ['value' => 'dob', 'title' => 'Date of Birth'],
        // ['value' => 'nationality', 'title' => 'Nationality'],
        ['value' => 'license_of', 'title' => 'License Of'],
        ['value' => 'vehicle', 'title' => 'Vehicle'],
        ['value' => 'pp_photo', 'title' => 'PP Size Photo'],
        ['value' => 'resume', 'title' => 'Resume'],
        ['value' => 'cover_letter', 'title' => 'Cover Letter'],
        ['value' => 'education', 'title' => 'Education'],
        ['value' => 'experience', 'title' => 'Experience'],
        ['value' => 'training', 'title' => 'Training'],
        ['value' => 'language', 'title' => 'Language'],
        ['value' => 'reference', 'title' => 'Reference'],
        ['value' => 'address', 'title' => 'Address']
    ];
    const JOB_TYPE = [
        'Hot', 'Featured', 'Free', 'News Paper'
    ];
    const JOB_EXP_FORMAT = [
        'Year', 'Month'
    ];
    const FORM_FIELDS = [
        ['value' => 'text', 'title' => 'Text'],
        ['value' => 'textarea', 'title' => 'Textarea'],
        ['value' => 'email', 'title' => 'Email'],
        ['value' => 'url', 'title' => 'Url'],
        ['value' => 'select', 'title' => 'Select'],
        ['value' => 'redio', 'title' => 'Redio Button'],
        ['value' => 'checkbox', 'title' => 'Check Box'],
        ['value' => 'file', 'title' => 'File Upload']
    ];
    const JOB_CONFIDENTIALITY = '<span style="color:#0033cc"><strong>&ldquo;Protocols for the confidentiality&rdquo;</strong></span> is designed to collect and maintain identifiable information about applicants. Data will be collected anonymously by the specified person and will be removed and destroyed as soon as possible by the completion of this specific assignment. No access to any other organizations/ person and shall be based on a &ldquo;need to know&rdquo; and &quot;minimum necessary&quot; standard.<br />
    <br />
    <span style="color:#FF0000"><strong>CONFIDENTIALITY PROTOCOL&mdash; PROTECTION OF INFORMATION OF APPLICANTS</strong></span><br />
    <br />
    <strong>STRICTLY CONFIDENTIAL</strong><br />
    <br />
    Information, applications and documents that are deemed to be of a highly sensitive nature or to be inadequately protected by the CONFI&not;DENTIAL classification shall be classified as STRICTLY CONFIDENTIAL and access to them shall be restricted solely to persons with a specific need for specific assignment only.<br />
    <br />
    The staffs of the Rolling Plans including client institution shall establish a control and tracking system for documents classified as STRICTLY CONFIDENTIAL, including the maintenance of control logs. Documents classified as STRICTLY CONFIDENTIAL shall be (i) maintained by only specific staff with written commitment; (ii) kept under security key or given equivalent protection when not in use; and (iii) in the case of physical documents, transmitted by an inner envelope indicating the classification marking and an outer envelope indicating no classification, or, in the case of documents in electronic form, transmitted by encrypted or password-secured system.<br />
    <br />
    For purposes of this protocol, the following individuals are deemed to have a specific need to know: (i) the executive consultant; (ii) the project manager/recruitment and selection consultant; (iii) the international consultant of Rolling Plans and; (v) the respective designated representatives of Government of Nepal.<br />
    <br />
    Confidentiality pertains to the treatment of information that an individual has disclosed in any documents/files of trust and with the expectation that it will not be divulged to others/ process without permission in ways that are inconsistent with the understanding of the original disclosure. Rolling Plans assure that the information shall be used for specific purpose published in this system and service only.<br />
    <br />
    When it is necessary to collect and maintain identifiable data, Rolling Plans will ensure that the protocol includes the necessary safeguards to maintain confidentiality of identifiable data and data security appropriate to the degree of risk from disclosure.';

    const JOB_DEFAULT_EMAIL_TEXT = "
        Dear %applicant_name%
        Thank You
        %app_name%
    ";
}