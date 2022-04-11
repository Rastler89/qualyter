<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
    use HasFactory;
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name',
        'expiration',
        'priority',
        'owner',
        'store',
        'description'
    ];

    public function owner() {
        return $this->belongsTo(Agent::class);
    }
}
