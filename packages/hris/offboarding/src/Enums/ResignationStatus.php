<?php 

namespace Hris\Offboarding\Enums;

enum ResignationStatus:string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}