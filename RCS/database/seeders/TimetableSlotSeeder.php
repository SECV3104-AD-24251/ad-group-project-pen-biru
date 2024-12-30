<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimetableSlot;

class TimetableSlotSeeder extends Seeder
{
    public function run()
    {
        $rooms = ['Room A', 'Room B', 'Room C'];
        $dates = now()->startOfMonth()->daysUntil(now()->endOfMonth());

        foreach ($rooms as $room) {
            foreach ($dates as $date) {
                TimetableSlot::create([
                    'room_name' => $room,
                    'date' => $date,
                    'slot' => 'morning',
                ]);

                TimetableSlot::create([
                    'room_name' => $room,
                    'date' => $date,
                    'slot' => 'evening',
                ]);
            }
        }
    }
}
