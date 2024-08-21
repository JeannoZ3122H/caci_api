<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideUneModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'slide_img',
        'description',
        'slug'
    ];
}
