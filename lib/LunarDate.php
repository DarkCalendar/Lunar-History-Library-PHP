<?php

namespace DarkCalendar\LunarDate;

use DarkCalendar\SolarDate\SolarDateService;
use DevNull\Facades\Facade;

/**
 * @method static SolarDateService solarDate()
 * @method static array|string     date($format, string|int $timestamp = '', string $time_zone = 'Asia/Baghdad', string $tr_num = 'fa')
 * @method static array|string     tr_num($str, string $mod = 'en', string $mf = '٫')
 * @method static array|string     solar_to_lunar(string|int $s_y, string|int $s_m, string|int $s_d, string $mod = '')
 * @method static array|string     lunar_to_gregorian(string|int $l_y, string|int $l_m, string|int $l_d, string $mod = '')
 * @method static array|string     lunar_to_solar(string|int $l_y, string|int $l_m, string|int $l_d, string $mod = '')
 * @method static array|string     gregorian_to_lunar(string|int $g_y, string|int $g_m, string|int $g_d, string $mod = '')
 * @method static float            ard_int($float)
 * @method static bool             isLeapYearG($year)
 * @method static bool             isLeapYearL($year)
 */
class LunarDate extends Facade
{
    public static function setNameSpace(): string
    {
        return LunarDateService::class;
    }
}