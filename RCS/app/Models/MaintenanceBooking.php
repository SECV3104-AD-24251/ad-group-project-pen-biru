<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceBooking extends Model
{
    protected $fillable = ['date', 'time', 'task', 'block_name', 'room', 'priority', 'booking_status'];
}

