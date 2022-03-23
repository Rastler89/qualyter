<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Store extends Model
{
    use HasFactory, Sortable;

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

    public $sortable = [
        'code',
        'name'
    ];

    
    public function client() {
        return $this->belongsTo(Client::class);
    }
}
