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
        'item_order',
        'type_media',
        'description',
        'title',
        'event_illustration',
        'slug'
    ];
}
