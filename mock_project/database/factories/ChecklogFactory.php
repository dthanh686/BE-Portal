<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 1;
        $day = 3;
        $checkin = mktime(8, random_int(5, 59), random_int(0, 59), 5, $day, 2022);
        $exit = mktime(random_int(9, 17), random_int(0, 59), random_int(0, 59), 5, $day, 2022);
        $checkout = mktime(17, random_int(20, 50), random_int(0, 59), 5, $day, 2022);
        return [
            'member_id' => $id++,
            'checktime' => date('Y-m-d H:i:s', $checkout),
            'date' => '2022-05-'.$day,
            'created_at' => date('Y-m-d H:i:s', $checkout),
        ];
    }
}
