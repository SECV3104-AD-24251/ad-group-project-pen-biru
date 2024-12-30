<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableSlot extends Model
{
    use HasFactory;

    // Define the fillable fields to protect against mass-assignment vulnerability
    protected $fillable = [
        'room_name',
        'day',
        'start_time',
        'end_time',
        'subject',
        'instructor',
    ];
}
