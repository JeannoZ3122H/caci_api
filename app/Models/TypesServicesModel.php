<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesServicesModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'item_order',
        'type_service',
        'description',
        'icon',
        'type_service_code',
        'slug'
    ];
}
