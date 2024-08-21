<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'type_event_id',
        'url',
        'description',
        'title',
        'event_img',
        'slug'
    ];
}
