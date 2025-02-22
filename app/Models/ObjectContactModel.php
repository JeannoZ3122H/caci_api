<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectContactModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'item_order',
        'contact_object',
        'status',
        'slug'
    ];
}
