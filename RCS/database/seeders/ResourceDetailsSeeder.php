<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceDetailsSeeder extends Seeder
{
    public function run()
    {
        $details = [
            ['resource_type' => 'Projector', 'detail' => 'Blurry image', 'severity' => 2],
            ['resource_type' => 'Projector', 'detail' => 'Bulb issue', 'severity' => 3],
            ['resource_type' => 'Chair', 'detail' => 'Broken leg', 'severity' => 2],
            ['resource_type' => 'Chair', 'detail' => 'Loose screw', 'severity' => 1],
            ['resource_type' => 'Table', 'detail' => 'Cracked surface', 'severity' => 3],
            ['resource_type' => 'Table', 'detail' => 'Wobbly', 'severity' => 2],
            ['resource_type' => 'PC', 'detail' => 'Blue Screen of Death', 'severity' => 3],
            ['resource_type' => 'PC', 'detail' => 'Slow performance', 'severity' => 2],
            ['resource_type' => 'Monitor', 'detail' => 'Screen flickering', 'severity' => 2],
            ['resource_type' => 'Network', 'detail' => 'No connection', 'severity' => 3],
            ['resource_type' => 'Network', 'detail' => 'Slow speed', 'severity' => 2],
        ];

        DB::table('resource_details')->insert($details);
    }
}
