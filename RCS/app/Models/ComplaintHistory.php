<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintHistory extends Model
{
    use HasFactory;

    protected $fillable = ['complaint_id', 'status', 'remarks', 'changed_at'];

    // Relationship to Complaint
    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }
}
