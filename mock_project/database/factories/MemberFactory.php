<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => 'nam',
            'email' => 'test'.$this->faker->unique()->numberBetween(100, 999).'@gmail.com',
            'avatar' => $this->faker->image('storage/app/public/images', 480, 480, null, false),
            'created_by' => 1,
            'password' => Hash::make('123456'), // password
            'remember_token' => Str::random(10),
        ];
    }
}
