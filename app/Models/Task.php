<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    
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

    public function answer() {
        return $this->belgonsTo(Answer::class);
    }
}
