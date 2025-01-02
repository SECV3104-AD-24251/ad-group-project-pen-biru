<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimetableSeeder extends Seeder
{
    public function run()
    {
        $rowsData = [
            ['block' => 'A', 'room_name' => 'Lab Room', 'day' => 'Monday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Physics', 'instructor' => 'Dr. Smith'],
            ['block' => 'A', 'room_name' => 'CCNA Room', 'day' => 'Monday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Johnson'],
            ['block' => 'A', 'room_name' => 'CGMTL', 'day' => 'Tuesday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Mr. Lee'],
            ['block' => 'A', 'room_name' => 'MPK1', 'day' => 'Tuesday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Math', 'instructor' => 'Dr. Adams'],
            ['block' => 'A', 'room_name' => 'MPK2', 'day' => 'Wednesday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Physics', 'instructor' => 'Ms. Brown'],
            ['block' => 'A', 'room_name' => 'MPK3', 'day' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Dr. Clark'],
            ['block' => 'A', 'room_name' => 'MPK4', 'day' => 'Thursday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Ms. Lewis'],
            ['block' => 'A', 'room_name' => 'MPK5', 'day' => 'Thursday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Math', 'instructor' => 'Mr. White'],
            ['block' => 'A', 'room_name' => 'MPK6', 'day' => 'Friday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Physics', 'instructor' => 'Dr. Hall'],
            ['block' => 'A', 'room_name' => 'MPK7', 'day' => 'Friday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Young'],
            ['block' => 'B', 'room_name' => 'DL Lab 1', 'day' => 'Monday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Chemistry', 'instructor' => 'Mr. Hill'],
            ['block' => 'B', 'room_name' => 'DL Lab 2', 'day' => 'Monday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Walker'],
            ['block' => 'B', 'room_name' => 'DL Lab 3', 'day' => 'Tuesday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Dr. Allen'],
            ['block' => 'B', 'room_name' => 'BK1', 'day' => 'Tuesday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Biology', 'instructor' => 'Ms. King'],
            ['block' => 'B', 'room_name' => 'BK2', 'day' => 'Wednesday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Chemistry', 'instructor' => 'Mr. Wright'],
            ['block' => 'B', 'room_name' => 'BK3', 'day' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Scott'],
            ['block' => 'B', 'room_name' => 'BK4', 'day' => 'Thursday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Dr. Green'],
            ['block' => 'B', 'room_name' => 'BK5', 'day' => 'Thursday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Biology', 'instructor' => 'Ms. Baker'],
            ['block' => 'B', 'room_name' => 'BK6', 'day' => 'Friday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Chemistry', 'instructor' => 'Mr. Adams'],
            ['block' => 'B', 'room_name' => 'BK7', 'day' => 'Friday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Perez'],
            ['block' => 'C', 'room_name' => 'Lab Room', 'day' => 'Monday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Math', 'instructor' => 'Dr. Miller'],
            ['block' => 'C', 'room_name' => 'CCNA Room', 'day' => 'Monday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'IT Security', 'instructor' => 'Ms. Harris'],
            ['block' => 'C', 'room_name' => 'CGMTL', 'day' => 'Tuesday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'CGMTL', 'instructor' => 'Mr. Cooper'],
            ['block' => 'C', 'room_name' => 'MPK1', 'day' => 'Tuesday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'AI', 'instructor' => 'Dr. Ward'],
            ['block' => 'C', 'room_name' => 'MPK2', 'day' => 'Wednesday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Math', 'instructor' => 'Ms. Cox'],
            ['block' => 'C', 'room_name' => 'MPK3', 'day' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'IT Security', 'instructor' => 'Dr. Morgan'],
            ['block' => 'C', 'room_name' => 'MPK4', 'day' => 'Thursday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'CGMTL', 'instructor' => 'Ms. Diaz'],
            ['block' => 'C', 'room_name' => 'MPK5', 'day' => 'Thursday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'AI', 'instructor' => 'Mr. Bryant'],
            ['block' => 'C', 'room_name' => 'MPK6', 'day' => 'Friday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Math', 'instructor' => 'Dr. Davis'],
            ['block' => 'C', 'room_name' => 'MPK7', 'day' => 'Friday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'IT Security', 'instructor' => 'Ms. Brooks'],
        ];

        foreach ($rowsData as $row) {
            DB::table('timetable_slots')->insert($row);
        }
    }
}
