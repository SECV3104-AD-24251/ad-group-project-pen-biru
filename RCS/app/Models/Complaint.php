<?php

namespace App\Models;
use App\Models\ComplaintHistory;

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

    //log status changes in the complaint_histories table
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($complaint) {
            // Check if the 'status' field is changed
            if ($complaint->isDirty('status')) {
                ComplaintHistory::create([
                    'complaint_id' => $complaint->id,
                    'status' => $complaint->status,
                    'remarks' => "Status updated to {$complaint->status}",
                    'changed_at' => now(),
                ]);
            }
        });
    }
}
