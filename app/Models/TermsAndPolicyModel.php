<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsAndPolicyModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'user_id',
        'description',
        'slug'
    ];
}
