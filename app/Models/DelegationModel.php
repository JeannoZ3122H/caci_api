<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelegationModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'representant_id',
        'libelle',
        'url_google_map',
        'phone',
        'fax',
        'email',
        'delegation_address',
        'url_google_map_safe',
        'iframe_google_map',
        'slug'
    ];
}
