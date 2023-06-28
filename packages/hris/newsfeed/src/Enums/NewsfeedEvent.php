<?php

namespace Hris\Newsfeed\Enums;

enum NewsfeedEvent:int
{
    case BIRTHDAY = 1;
    case ANNIVERSARY = 2;
    case ACHIEVEMENT = 3;
    case PROMOTION = 4;
    case MARRIAGE = 5;
    
}