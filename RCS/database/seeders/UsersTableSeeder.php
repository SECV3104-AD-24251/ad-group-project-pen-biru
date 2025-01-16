<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Ikhwanul Muslimin',
                'email' => 'technician@example.com',
                'password' => Hash::make('password123'),
                'role' => 'technician',
            ],
            [
                'name' => 'Ahmad Zahirudin',
                'email' => 'staff@example.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ],
            [
                'name' => 'Abid Abidol',
                'email' => 'student@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
        ]);
    }
}
