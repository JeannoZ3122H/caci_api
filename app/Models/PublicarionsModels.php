<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicarionsModels extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'type_publication_id',
        'libelle',
        'type_file',
        'url_file',
        'url',
        'slug'
    ];

}
