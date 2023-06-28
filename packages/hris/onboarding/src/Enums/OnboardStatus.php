<?php 

namespace Hris\Onboarding\Enums;

enum OnboardStatus:string
{
    case PENDING = 'Pending';
    case ACCEPT = 'Accepted';
    case REJECT = 'Rejected';
    
}