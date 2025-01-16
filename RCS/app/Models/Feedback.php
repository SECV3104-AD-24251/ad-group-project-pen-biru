<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $fillable = [
        'resource_availability',
        'resource_quality',
        'ease_of_reporting',
        'ease_of_use',
        'response_time',
        'clarity_of_process',
        'overall_experience',
        'suggestions',
    ];
}
