<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\Member::factory(500)->create();
//        \App\Models\MemberRole::factory(500)->create();
//        \App\Models\MemberShift::factory(500)->create();
//        \App\Models\Worksheet::factory(500)->create();
        \App\Models\Checklog::factory(500)->create();
    }
}
