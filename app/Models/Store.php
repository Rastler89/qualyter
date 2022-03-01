<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code',
        'name',
        'status',
        'phonenumber',
        'email',
        'language',
        'client',
        'contact'
    ];

    
    public function post() {
        return $this->belongsTo(Client::class);
    }
}
