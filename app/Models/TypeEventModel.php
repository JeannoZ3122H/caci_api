<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEventModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'item_order',
        'type_event',
        'slug'
    ];
}
