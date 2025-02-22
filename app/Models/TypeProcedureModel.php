<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProcedureModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'type_procedure',
        'slug'
    ];
}
