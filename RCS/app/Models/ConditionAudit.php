<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionAudit extends Model
{
    use HasFactory;

    protected $table = 'condition_audit';

    protected $fillable = ['room', 'resource', 'condition'];
}
