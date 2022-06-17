<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 1;
        $shift = 'Ca '.$id++;
        if ($shift == 'Ca 1') {
            $checkin = '8h30';
            $chckout = '17h30';
        } elseif($shift == 'Ca 2') {
            $checkin = '8h';
            $chckout = '17h';
        } else {
            $checkin = '9h';
            $chckout = '18h';
        }
        return [
            'shift_name' => $shift,
            'check_in' => $checkin,
            'check_out' => $chckout,
            'work_time' => 8,
            'lunch_break' => 60,
            'note' => 'note',
        ];
    }
}
