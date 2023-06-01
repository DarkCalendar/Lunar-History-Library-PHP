<?php

use DarkCalendar\LunarDate\LunarDate;
// Faster Version 9
if (!function_exists('gregorian')) {
    /**
     * @param string $format
     * @param string|int $timestamp
     * @return array|string
     */
    function gregorian(string $format = '', string|int $timestamp = ''): array|string
    {
        if ($format == '') {
            return explode('-', date('Y-m-d', $timestamp));
        }
        return date($format, $timestamp);
    }
}


if (!function_exists('gregorian_to_lunar')) {
    /**
     * @param $gy
     * @param $gm
     * @param $gd
     * @param string $mod
     * @return array|string
     */
    function gregorian_to_lunar($gy, $gm, $gd, string $mod = ''): array|string
    {
        return LunarDate::gregorian_to_lunar($gy, $gm, $gd, $mod);
    }
}

if (!function_exists('lunar_to_gregorian')) {
    /**
     * @param $ly
     * @param $lm
     * @param $ld
     * @param string $mod
     * @return array|string
     */
    function lunar_to_gregorian($ly, $lm, $ld, string $mod = ''): array|string
    {
        return LunarDate::lunar_to_gregorian($ly, $lm, $ld, $mod);
    }
}

if (!function_exists('solar_to_lunar')) {
    /**
     * @param $sy
     * @param $sm
     * @param $sd
     * @param string $mod
     * @return array|string
     */
    function solar_to_lunar($sy, $sm, $sd, string $mod = ''): array|string
    {
        return LunarDate::solar_to_lunar($sy, $sm, $sd, $mod);
    }
}


if (!function_exists('lunar_to_solar')) {
    /**
     * @param $ly
     * @param $lm
     * @param $ld
     * @param string $mod
     * @return array|string
     */
    function lunar_to_solar($ly, $lm, $ld, string $mod = ''): array|string
    {
        return LunarDate::lunar_to_solar($ly, $lm, $ld, $mod);
    }
}
