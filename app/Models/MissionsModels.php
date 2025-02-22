<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionsModels extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'title',
        'sub_title',
        'description',
        'illustration',
        'slug'
    ];
}
