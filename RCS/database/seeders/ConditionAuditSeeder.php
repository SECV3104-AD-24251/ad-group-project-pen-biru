<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConditionAudit;

class ConditionAuditSeeder extends Seeder
{
    public function run()
    {
        $rooms = ['CGMTL Room', 'CCNA Room', 'BK1', 'BK2', 'BK3', 'MPK1', 'MPK2', 'MPK3'];
        $resources = ['Projector'];

        // Add PCs (PC1 to PC25)
        for ($i = 1; $i <= 25; $i++) {
            $resources[] = 'pc' . $i;
        }

        foreach ($rooms as $room) {
            foreach ($resources as $resource) {
                ConditionAudit::create([
                    'room' => $room,
                    'resource' => $resource,
                    'condition' => 'USABLE'
                ]);
            }
        }
    }
}
