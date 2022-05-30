<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $random = 1;
        return [
            'published_date' => $this->faker->date(),
            'subject' => $this->faker->lastName,
            'email' => 'test' . $random++ . '@gmail.com',
            'avatar' => 'http://127.0.0.1:8000/storage/avatar/avatar.png',
            'created_by' => 1,
        ];
    }
}
