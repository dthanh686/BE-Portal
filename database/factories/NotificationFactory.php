<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $divionId = DB::table('divisions')->pluck('id');
        $createBy = DB::table('members')->pluck('created_by');
        static $i = 1;
        return [
            'published_date' => $this->faker->date(),
            'subject' => 'Thông báo chuyển văn phòng lần thứ' . $i++ ,
            'status' => rand(0, 3),
            'attachment' => 'http://18.141.177.206/storage/file/notifications/62a9ef604a1d2-Relipa_Portal_Database_Detail.xlsx',
            'published_to' => json_encode([$this->faker->randomElement($divionId)]),
            'created_by' => $this->faker->randomElement($createBy),
            'message' => 'Tất cả được nghỉ làm 1 năm(Vẫn nhận lương như bình thường)',
        ];
    }
}
