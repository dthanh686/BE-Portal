<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class DivisionMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $divison = DB::table('divisions')->pluck('id');
        $member = DB::table('members')->pluck('id');
            return [
                'member_id' => $this->faker->randomElement($member),
                'division_id' => $this->faker->randomElement($divison),
            ];
    }
}
