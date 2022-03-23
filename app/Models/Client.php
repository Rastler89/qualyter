<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'id',
        'name',
        'delegation',
        'phonenumber',
        'email',
        'language'
    ];

    public $sortable = [
        'name',
        'delegation'
    ];

    public function comments() {
        return $this->hasMany(Store::class);
    }
}
