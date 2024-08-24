<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesServicesModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'type_service',
        'type_service_code',
        'slug'
    ];
}
