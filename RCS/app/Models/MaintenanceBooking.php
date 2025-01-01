<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceBooking extends Model
{
    protected $fillable = ['date', 'time', 'task', 'block_name', 'room', 'priority', 'booking_status'];

    protected $casts = [
        'date' => 'date',          // Cast 'date' field to a Carbon date object
        'time' => 'datetime:H:i', // Cast 'time' to a Carbon time object
    ];
}