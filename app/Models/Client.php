<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use OwenIt\Auditing\Contracts\Auditable;

class Client extends Model implements Auditable
{
    use HasFactory, Sortable, \OwenIt\AUditing\Auditable;

    protected $fillable = [
        'id',
        'name',
        'delegation',
        'phonenumber',
        'email',
        'language',
        'extra'
    ];

    public $sortable = [
        'name',
        'delegation'
    ];

    public function comments() {
        return $this->hasMany(Store::class);
    }
}
