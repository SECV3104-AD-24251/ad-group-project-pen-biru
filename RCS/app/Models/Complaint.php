<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'block_name',
        'room',
        'resource_type',
        'description',
        'image',
        'priority',
    ];   

    // Define the relationship with ComplaintHistory
    public function histories()
    {
        return $this->hasMany(ComplaintHistory::class, 'complaint_id');
    }
}
