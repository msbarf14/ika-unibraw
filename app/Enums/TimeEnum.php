<?php

namespace App\Enums;

class TimeEnum
{
    public static function generateTimeRange()
    {
        $startTime = strtotime('07:00 AM');
        $endTime = strtotime('05:00 PM');
        $interval = 15 * 60;

        $times = collect();

        while ($startTime <= $endTime) {
            $times->push(date('H:i A', $startTime));
            $startTime += $interval;
        }

        return $times;
    }
}
