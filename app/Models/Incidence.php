<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class Incidence extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $dates = ['closed'];

    protected $fillable = [
        'id',
        'store',
        'client',
        'owner',
        'responsable',
        'impact',
        'status',
        'comments',
        'closed',
        'created_at'
    ];
}
