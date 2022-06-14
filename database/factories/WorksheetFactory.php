<?php

namespace Database\Factories;

use App\Models\Checklog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class WorksheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 0;
        static $day = 1;
        static $month = 3;
        static $year = 2022;
        $workDate = $year.'-'.$month.'-'.$day;
        if ($id == 99) {
            $day++;
        }
        if ($month % 2 != 0) {
            if ($day == 32) {
                $day = 1;
                $month = $month+1;
            }
        } else {
            if ($month == 2) {
                if ($day >= 29) {
                    if (!checkdate($month, $day, $year)) {
                        $day = 1;
                        $month= $month+1;
                    }
                }
            } else {
                if ($day == 31) {
                    $day = 1;
                    $month= $month+1;
                }
            }

        }
        $memberId = $id++ < 100 ? $id : $id=1;
        $checkLog = Checklog::where('member_id', $memberId)->where('date', $workDate);
        $checkIN = $checkLog->first()->checktime ?? null;
        $checkOUT = $checkLog->latest()->first()->checktime ?? null;

        $ot = mktime(18, 30, 0, $month, $day, $year);
        $start = mktime(8, 30, 0, $month, $day, $year);
        $finish = mktime(17, 30, 0, $month, $day, $year);
        $OT = new \DateTime(date('H:I', $ot));
        $START = new \DateTime(date('H:i', $start));
        $END = new \DateTime(date('H:i', $finish));
        $CHECKIN = new \DateTime(date('H:i', strtotime($checkIN)));
        $CHECKOUT = new \DateTime(date('H:i', strtotime($checkOUT)));
        $LATE = $CHECKIN->diff($START)->format('%H:%i');
        $EARLY = $END->diff($CHECKOUT)->format('%H:%i');
        $late = strtotime($checkIN) > $start ? date('H:i', strtotime($LATE)) : null;
        $early = strtotime($checkOUT) < $finish ? date('H:i', strtotime($EARLY)) : null;
        $inOffice = $CHECKOUT->diff($CHECKIN)->format("%H:%i");
        $timeworkOffice =  date('H:i', ($finish-$start));
        $a = $late != null ? new \DateTime($late) : null;
        $b = $early != null ? new \DateTime($early) : null;
        $a != null ? $interval1 = $a->diff(new \DateTime('00:00')) : false;
        $b != null ?$interval2 = $b->diff(new \DateTime('00:00')) : false;
        $e = new \DateTime('00:00');
        $f = clone $e;
        $late != null ? $e->add($interval1) : false;
        $early != null ? $e->add($interval2) : false;
        $late != null || $early !=null ? $total = $f->diff($e)->format("%H:%i") : $total = null;
        $total != null ? $lack = date('H:i', strtotime($total)) : $lack = null;
        $wt = new \DateTime('08:00');
        $worktime =  strtotime($checkIN) < $start && strtotime($checkOUT) > $finish ? $wt->format("%H:%i") :  $wt->diff(new \DateTime(date('H:i', strtotime($lack))))->format("%H:%i");
        $otTime = strtotime($checkOUT) > $ot ? $OT->diff($CHECKOUT)->format("%H:%i") : null;
        $otTime != null ? $timeOT = date('H:i', strtotime($otTime)) : $timeOT = null;
        $compensation = strtotime($checkOUT) > $finish ? $CHECKOUT->diff($END)->format("%H:%i") : null;
        $compensation != null ? $timeCompen = date('H:i', strtotime($compensation)) : $timeCompen = null;
        return [
            'member_id' => $memberId,
            'work_date' => $workDate,
            'checkin' => null,
            'checkin_original' => $checkIN,
            'checkout' => null,
            'checkout_original' => $checkOUT,
            'late' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $late : null,
            'early' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $early :null,
            'in_office' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('H:i', strtotime($inOffice)) : null,
            'work_time' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('H:i', strtotime($worktime)) : null,
            'lack' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $lack : null,
            'ot_time' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $timeOT : null,
            'compensation' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $timeCompen : null,
        ];
    }
}
