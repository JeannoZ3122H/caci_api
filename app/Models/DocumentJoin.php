<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentJoin extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'title',
        'libelle_document',
        'code_ref_libelle',
        'illustration',
        'slug'
    ];
}
