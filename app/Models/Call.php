<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'call_id',
        'type',
        'external_id'
    ];
}
