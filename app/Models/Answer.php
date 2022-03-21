<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Answer extends Model
{
    use HasFactory, Sortable;

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
