<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;


    protected $fileable = [
        'type_event_id',
        'author_id',
        'event_title',
        'event_description',
        'event_img',
        'slug'
    ];
}
