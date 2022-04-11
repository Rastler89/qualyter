<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use OwenIt\Auditing\Contracts\Auditable;

class Answer extends Model implements Auditable
{
    use HasFactory, Sortable, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id',
        'expiration',
        'status',
        'answer',
        'store',
        'token',
        'created_at'
    ];

    public $sortable = [
        'store',
        'expiration',
        'client'
    ];
}
