<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'delegation',
        'phonenumber',
        'email',
        'language'
    ];

    public function comments() {
        return $this->hasMany(Store::class);
    }
}
