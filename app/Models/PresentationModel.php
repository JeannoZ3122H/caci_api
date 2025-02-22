<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationModel extends Model
{
    use HasFactory;


    protected $fileable = [
        'type_event_id',
        'author_id',
        'title',
        'item_order',
        'description',
        'illustration',
        'type_media',
        'url',
        'slug'
    ];
}
