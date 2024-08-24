<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendasModels extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'title_event',
        'price',
        'description_event',
        'date_start_event',
        'date_end_event',
        'status_enter_event',
        'address_event',
        'localisation_event',
        'illusration_event',
        'slug'
    ];
}
