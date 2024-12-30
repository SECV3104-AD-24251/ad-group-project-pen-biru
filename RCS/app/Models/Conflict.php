<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conflict extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'time', 'room', 'description'];

    // If you want to define the table name (optional, as Laravel assumes plural form of model)
    protected $table = 'conflicts';
}
