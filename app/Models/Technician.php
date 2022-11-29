<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'company',
        'nif',
        'contact',
        'country',
        'region',
        'town',
        'address',
        'main_phone',
        'admin_phone',
        'all_phone',
        'main_email',
        'admin_email',
        'all_email',
        'services',
        'workers',
        'info_workers',
        'travel',
        'travel_ah',
        'hour',
        'hour_ah',
        'type_payment',
        'iban',
        'risk',
        'preventive',
        'certificate_pay',
        'rnt',
        'rlc',
        'tax',
        'crated_at'
    ];
}
