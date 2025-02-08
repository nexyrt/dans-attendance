<?php
// app/Traits/DateTimeComparison.php

namespace App\Traits;

use Cake\Chronos\Chronos;

trait DateTimeComparison
{
    /**
     * Check if a given time falls within a specified range
     *
     * @param Chronos $time The time to check
     * @param Chronos $start Start of the range
     * @param Chronos $end End of the range
     * @return bool
     */
    protected function isTimeInRange(Chronos $time, Chronos $start, Chronos $end): bool
    {
        return $time->greaterThanOrEquals($start) && 
               $time->lessThanOrEquals($end);
    }

    /**
     * Format time for display in views
     *
     * @param Chronos $time
     * @return string
     */
    protected function formatTimeForDisplay(Chronos $time): string
    {
        return $time->format('H:i');
    }

    /**
     * Get tolerance limit for a given start time
     *
     * @param Chronos $startTime
     * @param int $toleranceMinutes
     * @return Chronos
     */
    protected function getToleranceLimit(Chronos $startTime, int $toleranceMinutes): Chronos
    {
        return $startTime->addMinutes($toleranceMinutes);
    }
}