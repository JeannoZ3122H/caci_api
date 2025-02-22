<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionDelegationModel extends Model
{

    use HasFactory;

    protected $fileable = [
        'sup_title',
        'title',
        'description',
        'slug'
    ];
}
