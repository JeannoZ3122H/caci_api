<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamsModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'fname',
        'person_img',
        'lname',
        'fonction',
        'phone',
        'email',
        'slug'
    ];
}
