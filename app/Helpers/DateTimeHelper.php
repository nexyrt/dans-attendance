<?php
// app/Helpers/DateTimeHelper.php

namespace App\Helpers;

use Cake\Chronos\Chronos;

class DateTimeHelper
{
    /**
     * Get current time
     *
     * @return Chronos
     */
    public static function now(): Chronos
    {
        return Chronos::now();
    }

    /**
     * Parse a time string into Chronos instance
     *
     * @param string $time
     * @return Chronos
     */
    public static function parse(string $time): Chronos
    {
        return Chronos::parse($time);
    }

    /**
     * Get today's date as string
     *
     * @return string
     */
    public static function today(): string
    {
        return Chronos::today()->toDateString();
    }

    /**
     * Get current day name in lowercase
     *
     * @return string
     */
    public static function currentDayName(): string
    {
        return strtolower(Chronos::now()->format('l'));
    }
}