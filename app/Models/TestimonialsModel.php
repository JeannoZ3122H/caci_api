<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialsModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'fname',
        'lname',
        'fonction',
        'phone',
        'description',
        'slug'
    ];
}
