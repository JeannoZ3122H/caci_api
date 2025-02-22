<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionPublicationModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'sup_title',
        'icon',
        'banner',
        'description',
        'slug'
    ];
}
