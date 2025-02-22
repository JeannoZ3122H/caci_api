<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisationsModels extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'section',
        'title',
        'item_order',
        'description',
        'code_org',
        'slug'
    ];
}
