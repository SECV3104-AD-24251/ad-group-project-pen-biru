<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimetableSeeder extends Seeder
{
    public function run()
    {
        $rowsData = [
            // Block A
            ['block' => 'A', 'room_name' => 'CGMTL', 'day' => 'Monday', 'start_time' => '08:00:00', 'end_time' => '10:00:00', 'subject' => 'Physics', 'instructor' => 'Dr. Smith'],
            ['block' => 'A', 'room_name' => 'Lab Room', 'day' => 'Monday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'subject' => 'Math', 'instructor' => 'Dr. Miller'],
            ['block' => 'A', 'room_name' => 'CCNA Room', 'day' => 'Monday', 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'subject' => 'AI', 'instructor' => 'Dr. Ward'],

            ['block' => 'A', 'room_name' => 'CGMTL', 'day' => 'Wednesday', 'start_time' => '08:00:00', 'end_time' => '10:00:00', 'subject' => 'Networking', 'instructor' => 'Ms. Johnson'],
            ['block' => 'A', 'room_name' => 'Lab Room', 'day' => 'Wednesday', 'start_time' => '12:00:00', 'end_time' => '14:00:00', 'subject' => 'Graphics', 'instructor' => 'Mr. Lee'],
            ['block' => 'A', 'room_name' => 'CCNA Room', 'day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'subject' => 'Chemistry', 'instructor' => 'Ms. Walker'],

            // Block B
            ['block' => 'B', 'room_name' => 'BK1', 'day' => 'Monday', 'start_time' => '08:00:00', 'end_time' => '10:00:00', 'subject' => 'Math', 'instructor' => 'Dr. Miller'],
            ['block' => 'B', 'room_name' => 'BK2', 'day' => 'Monday', 'start_time' => '12:00:00', 'end_time' => '14:00:00', 'subject' => 'Networking', 'instructor' => 'Ms. Scott'],
            ['block' => 'B', 'room_name' => 'BK3', 'day' => 'Tuesday', 'start_time' => '08:00:00', 'end_time' => '10:00:00', 'subject' => 'Biology', 'instructor' => 'Ms. King'],

            ['block' => 'B', 'room_name' => 'BK1', 'day' => 'Wednesday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'subject' => 'Physics', 'instructor' => 'Dr. Clark'],
            ['block' => 'B', 'room_name' => 'BK2', 'day' => 'Thursday', 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'subject' => 'Graphics', 'instructor' => 'Dr. Green'],
            ['block' => 'B', 'room_name' => 'BK3', 'day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'subject' => 'AI', 'instructor' => 'Dr. Ward'],

            // Block C
            ['block' => 'C', 'room_name' => 'MPK1', 'day' => 'Monday', 'start_time' => '08:00:00', 'end_time' => '10:00:00', 'subject' => 'IT Security', 'instructor' => 'Ms. Harris'],
            ['block' => 'C', 'room_name' => 'MPK2', 'day' => 'Monday', 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'subject' => 'Graphics', 'instructor' => 'Ms. Diaz'],
            ['block' => 'C', 'room_name' => 'MPK3', 'day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'subject' => 'AI', 'instructor' => 'Dr. Morgan'],

            ['block' => 'C', 'room_name' => 'MPK1', 'day' => 'Wednesday', 'start_time' => '08:00:00', 'end_time' => '10:00:00', 'subject' => 'Math', 'instructor' => 'Dr. Davis'],
            ['block' => 'C', 'room_name' => 'MPK2', 'day' => 'Thursday', 'start_time' => '12:00:00', 'end_time' => '14:00:00', 'subject' => 'IT Security', 'instructor' => 'Ms. Brooks'],
            ['block' => 'C', 'room_name' => 'MPK3', 'day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'subject' => 'Chemistry', 'instructor' => 'Ms. Lewis'],
        ];

        foreach ($rowsData as $row) {
            DB::table('timetable_slots')->insert($row);
        }
    }
}
