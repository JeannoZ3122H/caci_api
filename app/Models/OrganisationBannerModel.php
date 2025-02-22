<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisationBannerModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'title',
        'type_media',
        'illustration',
        'description',
        'slug'
    ];
}
