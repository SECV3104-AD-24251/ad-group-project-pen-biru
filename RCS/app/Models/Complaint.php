<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    // Define fillable attributes
    protected $fillable = [
        'block_name',
        'room',
        'resource_type',
        'description',
        'image',
    ];

    // Define the relationship to the ComplaintStatus model
    public function statuses()
    {
        return $this->hasMany(ComplaintStatus::class);
    }
}
