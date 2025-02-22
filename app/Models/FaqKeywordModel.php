<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqKeywordModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'item_order',
        'faq_keyword',
        'slug'
    ];
}
