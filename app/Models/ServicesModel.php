<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'type_service_id',
        'author_id',
        'libelle',
        'subTitle',
        'code_ref',
        'description',
        'type_media',
        'illustration',
        'slug'
    ];
}
