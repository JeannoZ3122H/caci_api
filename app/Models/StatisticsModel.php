<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatisticsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'visites',
        'utilisateurs_uniques',
        'temps_moyen',
        'date',
        'dispositif',
        'navigateur',
        'source_traffic',
        'folders',
        'members',
    ];
}
