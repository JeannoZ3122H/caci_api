<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'matricule',
        'libelle',
        'type_content',
        'content',
        'slug'
    ];
}
