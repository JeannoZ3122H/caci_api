<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnersModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'item_order',
        'title',
        'partner',
        'description',
        'url_site',
        'is_favorited',
        'slug'
    ];
}
