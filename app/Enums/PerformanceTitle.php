<?php
namespace App\Enums;

enum PerformanceTitle:string
{
    case TASK = 'Task';
    case KPI = 'KPIs';
    case DISCIPLINE = 'Discipline';
    case PUNCTUALITY = 'Punctuality';
    case SUBORDINATE_RATING = 'Subordinate Rating';
    case ACHIEVEMENT = 'Achievement';
}