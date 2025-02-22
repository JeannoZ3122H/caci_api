<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotDuPresidentModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'author_id',
        'president',
        'poste',
        'title',
        'sub_title',
        'description',
        'illustration',
        'slug'
    ];
}
