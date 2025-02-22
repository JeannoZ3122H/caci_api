<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorFraisModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'libelle',
        'subTitle',
        'code_ref',
        'type_service_code',
        'description',
        'illustration',
        'slug'
    ];
}
