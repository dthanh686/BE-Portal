<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $random = 100;
        return [
            'full_name' => $this->faker->lastName,
//            'email' => 'test'.$this->faker->unique()->numberBetween(100, 999).'@gmail.com',
            'email' => 'test'.$random++.'@gmail.com',
            'created_by' => 1,
            'password' => Hash::make('123456'), // password
        ];
    }
}
