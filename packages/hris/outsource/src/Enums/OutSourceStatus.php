<?php 

namespace Hris\Outsource\Enums;

enum OutSourceStatus:string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'InActive';
    case HOLD = 'Hold';
    case TERMINATE = 'Terminate';
    case COMPLETED = 'Tenure Completed Successfully';
}