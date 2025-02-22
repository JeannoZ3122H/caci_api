<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SociauxModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'author_id',
        'item_order',
        'reseau_social',
        'icon',
        'slug'
    ];
}
