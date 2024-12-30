<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimetableSeeder extends Seeder
{
    public function run()
    {
        $rowsData = [
            ['block' => 'BlockA', 'room_name' => 'Lab Room', 'day' => 'Monday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Physics', 'instructor' => 'Dr. Smith'],
            ['block' => 'BlockA', 'room_name' => 'CCNA Room', 'day' => 'Monday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Johnson'],
            ['block' => 'BlockA', 'room_name' => 'CGMTL', 'day' => 'Tuesday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Mr. Lee'],
            ['block' => 'BlockA', 'room_name' => 'MPK1', 'day' => 'Tuesday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Math', 'instructor' => 'Dr. Adams'],
            ['block' => 'BlockA', 'room_name' => 'MPK2', 'day' => 'Wednesday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Physics', 'instructor' => 'Ms. Brown'],
            ['block' => 'BlockA', 'room_name' => 'MPK3', 'day' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Dr. Clark'],
            ['block' => 'BlockA', 'room_name' => 'MPK4', 'day' => 'Thursday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Ms. Lewis'],
            ['block' => 'BlockA', 'room_name' => 'MPK5', 'day' => 'Thursday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Math', 'instructor' => 'Mr. White'],
            ['block' => 'BlockA', 'room_name' => 'MPK6', 'day' => 'Friday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Physics', 'instructor' => 'Dr. Hall'],
            ['block' => 'BlockA', 'room_name' => 'MPK7', 'day' => 'Friday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Young'],
            ['block' => 'BlockB', 'room_name' => 'Lab Room', 'day' => 'Monday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Chemistry', 'instructor' => 'Mr. Hill'],
            ['block' => 'BlockB', 'room_name' => 'CCNA Room', 'day' => 'Monday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Walker'],
            ['block' => 'BlockB', 'room_name' => 'CGMTL', 'day' => 'Tuesday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Dr. Allen'],
            ['block' => 'BlockB', 'room_name' => 'MPK1', 'day' => 'Tuesday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Biology', 'instructor' => 'Ms. King'],
            ['block' => 'BlockB', 'room_name' => 'MPK2', 'day' => 'Wednesday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Chemistry', 'instructor' => 'Mr. Wright'],
            ['block' => 'BlockB', 'room_name' => 'MPK3', 'day' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Scott'],
            ['block' => 'BlockB', 'room_name' => 'MPK4', 'day' => 'Thursday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'Graphics', 'instructor' => 'Dr. Green'],
            ['block' => 'BlockB', 'room_name' => 'MPK5', 'day' => 'Thursday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'Biology', 'instructor' => 'Ms. Baker'],
            ['block' => 'BlockB', 'room_name' => 'MPK6', 'day' => 'Friday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Chemistry', 'instructor' => 'Mr. Adams'],
            ['block' => 'BlockB', 'room_name' => 'MPK7', 'day' => 'Friday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'Networking', 'instructor' => 'Ms. Perez'],
            ['block' => 'BlockC', 'room_name' => 'Lab Room', 'day' => 'Monday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Math', 'instructor' => 'Dr. Miller'],
            ['block' => 'BlockC', 'room_name' => 'CCNA Room', 'day' => 'Monday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'IT Security', 'instructor' => 'Ms. Harris'],
            ['block' => 'BlockC', 'room_name' => 'CGMTL', 'day' => 'Tuesday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'CGMTL', 'instructor' => 'Mr. Cooper'],
            ['block' => 'BlockC', 'room_name' => 'MPK1', 'day' => 'Tuesday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'AI', 'instructor' => 'Dr. Ward'],
            ['block' => 'BlockC', 'room_name' => 'MPK2', 'day' => 'Wednesday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Math', 'instructor' => 'Ms. Cox'],
            ['block' => 'BlockC', 'room_name' => 'MPK3', 'day' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'IT Security', 'instructor' => 'Dr. Morgan'],
            ['block' => 'BlockC', 'room_name' => 'MPK4', 'day' => 'Thursday', 'start_time' => '12:00', 'end_time' => '13:30', 'subject' => 'CGMTL', 'instructor' => 'Ms. Diaz'],
            ['block' => 'BlockC', 'room_name' => 'MPK5', 'day' => 'Thursday', 'start_time' => '14:00', 'end_time' => '15:30', 'subject' => 'AI', 'instructor' => 'Mr. Bryant'],
            ['block' => 'BlockC', 'room_name' => 'MPK6', 'day' => 'Friday', 'start_time' => '08:00', 'end_time' => '09:30', 'subject' => 'Math', 'instructor' => 'Dr. Davis'],
            ['block' => 'BlockC', 'room_name' => 'MPK7', 'day' => 'Friday', 'start_time' => '10:00', 'end_time' => '11:30', 'subject' => 'IT Security', 'instructor' => 'Ms. Brooks'],
        ];

        foreach ($rowsData as $row) {
            DB::table('timetable_slots')->insert($row);
        }
    }
}
