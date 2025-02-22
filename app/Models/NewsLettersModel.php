<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLettersModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'subscriber_email',
        'slug'
    ];
}
