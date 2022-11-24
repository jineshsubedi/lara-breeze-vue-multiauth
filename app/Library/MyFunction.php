<?php

namespace App\Library;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

    class MyFunction {

        public static function removeSpace($value)
        {
           //$string = str_replace(' ', '-', $value); // Replaces all spaces with hyphens.
            $string = preg_replace("/\s+/", "", $value);
            return $string; // Removes special chars.
        }
        public static function getDiffentDate($date1,$date2)
        {
            $datetime1 = new \DateTime($date1);
            $datetime2 = new \DateTime($date2);
            $interval = $datetime1->diff($datetime2);
            return $interval->format('%y years %m months and %d days');
        }
        public static function getLimitedWords($text,$startword,$numberOfWords)
        {
            if($text != null)
            {
                $text = strip_tags(html_entity_decode(str_replace("&nbsp;","",$text)));
                $textArray = explode(" ", $text);
                if(count($textArray) > $numberOfWords)
                {
                    return implode(" ",array_slice($textArray, $startword, $numberOfWords)).'...';
                }
                return strip_tags(html_entity_decode(str_replace("&nbsp;","",$text)));
            }
            return "";
        }
        public static function getLimitedCharacter($text,$startword,$numberOfWords)
        {
            if($text != null)
            {
                $text = strip_tags(str_replace("&nbsp;","",$text));


                return substr($text,$startword,$numberOfWords).'...';
            }
            return "";
        }
        public static function getDuration($start_time, $end_time)
        {
            $startTime = Carbon::parse($start_time);
            $endTime = Carbon::parse($end_time);
            $duration = $endTime->diffInMinutes($startTime);
            return $duration;
        }
        public static function isHeadBranch(): bool
        {
            return auth()->user()->branch->is_head == 1 ? true : false;
        }
    }

?>
