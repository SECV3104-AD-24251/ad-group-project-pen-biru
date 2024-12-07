<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;




use Illuminate\Support\Facades\DB;

class ComplaintSeeder extends Seeder
{
    public function run()
    {
        DB::table('complaints')->insert([
            ['date' => '2024-12-06', 'location' => 'Block A', 'priority' => 'high', 'created_at' => now(), 'updated_at' => now()],
            ['date' => '2024-12-07', 'location' => 'Block B', 'priority' => 'low', 'created_at' => now(), 'updated_at' => now()],
            ['date' => '2024-12-08', 'location' => 'Block C', 'priority' => 'normal', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
