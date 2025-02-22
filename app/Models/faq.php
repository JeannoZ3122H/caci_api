<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faq extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'ask',
        'answere',
        'keyword',
        'category_ask',
        'slug'
    ];
}
