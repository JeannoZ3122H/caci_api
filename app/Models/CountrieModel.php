<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountrieModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'countrie_name',
        'countrie_flag',
        'continent',
        'countrie_iso_code',
        'countrie_phone_code',
        'countrie_currency',
        'nationality',
        'slug'
    ];
}
