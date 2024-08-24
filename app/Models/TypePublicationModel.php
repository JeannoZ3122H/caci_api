<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePublicationModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'type_publication',
        'slug'
    ];
}
