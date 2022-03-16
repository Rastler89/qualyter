<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'owner',
        'responsable',
        'impact',
        'status',
        'comments',
        'closer',
        'created_at'
    ];
}
