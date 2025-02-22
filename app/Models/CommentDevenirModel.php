<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentDevenirModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'libelle',
        'subTitle',
        'code_ref',
        'description',
        'illustration',
        'slug'
    ];
}
