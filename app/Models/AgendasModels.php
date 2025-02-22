<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendasModels extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'type_event_id',
        'google_meet_url',
        'title_event',
        'price',
        'description_event',
        'date_start_event',
        'date_end_event',
        'hours_start_event',
        'hours_end_event',
        'status_enter_event',
        'address_event',
        'localisation_event',
        'url_google_map_safe',
        'iframe_google_map',
        'illusration_event',
        'slug'
    ];
}
