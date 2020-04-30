<?php

namespace App\Http\Controllers\HelperClass;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class DateTimeClass extends Controller
{
    //data and time calculation
    public function toPersian($date){
        $v = verta($date);
        $date=$v->formatDatetime();
        return  $date;// 1395-12-10 23:37:26
    }

    public function toPersianMonthName($date){
        $v = verta($date);
        $date=$v->formatDatetime();
        return $v->format('%d %B %Y');
//        return  $date;// 1395-12-10 23:37:26
    }
    public function changeTime($item){
        $item->ago=$this->ago($item->created_at);
        $item->date=$this->toPersianMonthName($item->created_at);
        $item->created_at=$this->toPersian($item->created_at);
        $item->updated_at=$this->toPersian($item->updated_at);
    }
    public function ago($time)
    {
        $v = verta(); //now
        $v2 = Verta::parse($this->toPersian($time)); //change date to persian and the change it as a Verta object
        return $v2->formatDifference($v); // then give me the different
    }
    public function diff_dates($date1,$date2){
        $d1 = Carbon::parse($date1);
        $d2 = Carbon::parse($date2);
        $diff = $d1->diffInDays($d2);
        return $diff;
    }
    public function jalali_to_gregorian($year, $month, $day, $mod = '')
    {
        if ($year > 979) {
            $gy = 1600;
            $year -= 979;
        } else {
            $gy = 621;
        }
        $days = (365 * $year) + (((int)($year / 33)) * 8) + ((int)((($year % 33) + 3) / 4)) + 78 + $day + (($month < 7) ? ($month - 1) * 31 : (($month - 7) * 30) + 186);
        $gy += 400 * ((int)($days / 146097));
        $days %= 146097;
        if ($days > 36524) {
            $gy += 100 * ((int)(--$days / 36524));
            $days %= 36524;
            if ($days >= 365) $days++;
        }
        $gy += 4 * ((int)(($days) / 1461));
        $days %= 1461;
        $gy += (int)(($days - 1) / 365);
        if ($days > 365) $days = ($days - 1) % 365;
        $gd = $days + 1;
        foreach (array(0, 31, ((($gy % 4 == 0) and ($gy % 100 != 0)) or ($gy % 400 == 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
            if ($gd <= $v) break;
            $gd -= $v;
        }

        return ($mod === '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
    }
    //separate year, month and day
    public function seprateDate($date){
        $holder= explode('/',$date);
        $year=$holder[0];
        $month=$holder[1];
        $day=$holder[2];
        $gregorian=$this->jalali_to_gregorian($year,$month,$day);
        return  $gregorian[0].'-'.$gregorian[1].'-'.$gregorian[2]; //2020-3-16
    }
}
