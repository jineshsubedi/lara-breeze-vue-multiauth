<?php

namespace Hris\Offboarding\Enums;

enum TerminationStatus:string
{
    case UNPROCESS = 'unprocess';
    case TERMINATE = 'terminate';
    case HIRE = 'hire';
}