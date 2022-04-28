<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use OwenIt\Auditing\Contracts\Auditable;

class Incidence extends Model implements Auditable
{
    use HasFactory, Sortable, \OwenIt\Auditing\Auditable;

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

    public $sortable = [
        'store',
        'status',
        'impact',
        'responsable',
        'owner',
        'closed'
    ];
}
