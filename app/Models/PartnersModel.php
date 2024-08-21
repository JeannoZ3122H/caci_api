<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnersModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'partner',
        'description',
        'url_site',
        'slug'
    ];
}
