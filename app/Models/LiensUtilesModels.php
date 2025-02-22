<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiensUtilesModels extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'sub_title',
        'title',
        'description',
        'global_link',
        'illustration_url',
        'slug'
    ];
}
