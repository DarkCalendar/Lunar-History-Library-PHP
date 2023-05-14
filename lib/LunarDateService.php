<?php

namespace DarkCalendar\LunarDate;

use DarkCalendar\SolarDate\SolarDateService;
use JetBrains\PhpStorm\Pure;

class LunarDateService
{
    /**
     * @return SolarDateService
     */
    private function solarDate(): SolarDateService
    {
        return new SolarDateService();
    }

    public function date($format, string|int $timestamp = '', string $time_zone = 'Asia/Baghdad', string $tr_num = 'fa'){
        $T_sec = 0;
        if ($time_zone != 'local') date_default_timezone_set(($time_zone === '') ? 'Asia/Baghdad' : $time_zone);
        $ts = $T_sec + (($timestamp === '') ? time() : $this->tr_num($timestamp));
        $date = explode('_', date('H_i_j_n_O_P_s_w_Y', $ts));
        list($l_y, $l_m, $l_d) = $this->gregorian_to_lunar($date[8], $date[3], $date[2]);
        $format_extract = mb_str_split($format);
        $m_days = [30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29];
        $doy = 0;
        foreach (range(0, $l_m) as $item) {
            $doy += $m_days[$item];
        }
        $doy += $l_d;
        $out = '';
        $y = ($l_y % 30);
        $kab = match ($y){
            2, 5, 7, 10, 13, 16, 18, 21, 24, 26, 26 => 1,
            default => 0
        };
        foreach ($format_extract as $sub) {
            if ($sub == '\\') {
                $out .= $sub;
                continue;
            }
            switch ($sub) {
                case 'B':
                case 'e':
                case 'g':
                case 'G':
                case 'h':
                case 'I':
                case 'T':
                case 'u':
                case 'Z':
                    $out .= date($sub, $ts);
                    break;

                case 'a':
                    $out .= ($date[0] < 12) ? 'ق.ظ' : 'ب.ظ';
                    break;

                case 'A':
                    $out .= ($date[0] < 12) ? 'صباحا' : 'مساءا';
                    break;

                case 'c':
                    $out .= $l_y . '/' . $l_m . '/' . $l_d . ' ،' . $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[5];
                    break;

                case 'd':
                    $out .= ($l_d < 10) ? '0' . $l_d : $l_d;
                    break;

                case 'D':
                case 'l':
                    $arDay = array(
                        "Sat" => "السبت",
                        "Sun" => "الأحد",
                        "Mon" => "الإثنين",
                        "Tue" => "الثلاثاء",
                        "Wed" => "الأربعاء",
                        "Thu" => "الخميس",
                        "Fri" => "الجمعة"
                    );
                    $out .= $arDay[date('D')];
                    break;
                case 'F':
                case 'M':
                    $hjMonth = array("", "محرم", "صفر", "ربيع أول", "ربيع ثاني",
                        " جمادي الاولي", "جماد ثاني", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");
                    $out .= $hjMonth[$l_m];
                    break;

                case 'H':
                    $out .= $date[0];
                    break;

                case 'i':
                    $out .= $date[1];
                    break;

                case 'j':
                    $out .= $l_d;
                    break;
                case 'L':
                    $out .= $kab;
                    break;

                case 'm':
                    $out .= ($l_m > 9) ? $l_m : '0' . $l_m;
                    break;


                case 'n':
                    $out .= $l_m;
                    break;

                case 'N':
                case 'w':
                    $out .= $date[7] + 1;
                    break;

                case 'o':
                    $jdw = ($date[7] == 6) ? 0 : $date[7] + 1;
                    $dny = 354 + $kab - $doy;
                    $out .= ($jdw > ($doy + 3) and $doy < 3) ? $l_y - 1 : (((3 - $dny) > $jdw and $dny < 3) ? $l_y + 1 : $l_y);
                    break;

                case 'O':
                    $out .= $date[4];
                    break;

                case 'P':
                    $out .= $date[5];
                    break;

                case 'r':
                    $hjMonth = array("", "محرم", "صفر", "ربيع أول", "ربيع ثاني",
                        " جمادي الاولي", "جماد ثاني", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");
                    $hjMonth = $hjMonth[$l_m];
                    $arDay = array(
                        "Sat" => "السبت",
                        "Sun" => "الأحد",
                        "Mon" => "الإثنين",
                        "Tue" => "الثلاثاء",
                        "Wed" => "الأربعاء",
                        "Thu" => "الخميس",
                        "Fri" => "الجمعة"
                    );
                    $arDay = $arDay[date('D')];
                    $out .= $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[4] . ' ' . $arDay . '، ' . $l_d . ' ' . $hjMonth . ' ' . $l_y;
                    break;

                case 's':
                    $out .= $date[6];
                    break;

                case 'S':
                    $out .= 'ام';
                    break;

                case 't':
                    $out .= ($l_m != 12) ? (31 - (int) ($l_m / 6.5)) : ($kab + 29);
                    break;

                case 'U':
                    $out .= $ts;
                    break;

                case 'W':
                case 'z':
                    $out .= $doy;
                    break;

                case 'y':
                    $out .= substr($l_y, 2, 2);
                    break;

                case 'Y':
                    $out .= $l_y;
                    break;
                default:
                    $out .= $sub;
            }
        }

        return $this->tr_num($out, $tr_num);
    }

    /**
     * @param $str
     * @param string $mod
     * @param string $mf
     * @return array|string
     */
    function tr_num($str, string $mod = 'en', string $mf = '٫'): array|string
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', $mf);
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }

    /**
     * @param string|int $s_y
     * @param string|int $s_m
     * @param string|int $s_d
     * @param string $mod
     * @return array|string
     */
    public function solar_to_lunar(string|int $s_y, string|int $s_m, string|int $s_d, string $mod = ''): array|string
    {
        return $this->gregorian_to_lunar(...[...$this->solarDate()->solar_to_gregorian($s_y, $s_m, $s_d), ...[$mod]]);
    }

    /**
     * @param string|int $g_y
     * @param string|int $g_m
     * @param string|int $g_d
     * @param string $mod
     * @return array|string
     */
    #[Pure] public function gregorian_to_lunar(string|int $g_y, string|int $g_m, string|int $g_d, string $mod = ''): array|string
    {
        unset(func_get_args()[3]);
        $timestamp = strtotime(implode("-", func_get_args()));
        list($d,$m,$y,$dayname,$monthname,$am)=explode(' ',date('d m Y D M a', $timestamp));

        if (($y>1582)||(($y==1582)&&($m>10))||(($y==1582)&&($m==10)&&($d>14))) {
            $jd=$this->ard_int((1461*($y+4800+$this->ard_int(($m-14)/12)))/4);
            $jd+=$this->ard_int((367*($m-2-12*($this->ard_int(($m-14)/12))))/12);
            $jd-=$this->ard_int((3*($this->ard_int(($y+4900+$this->ard_int(($m-14)/12))/100)))/4);
            $jd+=$d-32076;
        } else {
            $jd = 367*$y-$this->ard_int((7*($y+5001 + $this->ard_int(($m-9)/7)))/4) + $this->ard_int((275*$m)/9)+$d+1729777;
        }
        $l=$jd-1948440+10632;
        $n=$this->ard_int(($l-1)/10631);
        $l=$l-10631*$n+355; // Correction: 355 instead of 354
        $j=($this->ard_int((10985-$l)/5316)) * ($this->ard_int((50*$l)/17719)) + ($this->ard_int($l/5670)) * ($this->ard_int((43*$l)/15238));
        $l=$l-($this->ard_int((30-$j)/15)) * ($this->ard_int((17719*$j)/50)) - ($this->ard_int($j/16)) * ($this->ard_int((15238*$j)/43))+29;
        $m=$this->ard_int((24*$l)/709);
        $d=$l-$this->ard_int((709*$m)/24);
        $y=30*$n+$j-30;
        if (empty($mod))
            return [
                (int)$y,(int)$m,(int)$d,
            ];
        return implode($mod, [$y, $m, $d]);
    }

    function ard_int($float): float
    {
        return ($float < -0.0000001) ? ceil($float-0.0000001) : floor($float+0.0000001);
    }


}