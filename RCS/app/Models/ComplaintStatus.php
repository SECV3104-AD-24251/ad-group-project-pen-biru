<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatus extends Model
{
    protected $fillable = [
        'complaint_id',  // Add this line
        'status'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
