<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReseauxSociauxModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'item_order',
        'reseau_social',
        'link',
        'icon',
        'slug'
    ];
}
