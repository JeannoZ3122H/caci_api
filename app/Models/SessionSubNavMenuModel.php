<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionSubNavMenuModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'nav_item_id',
        'item_order',
        'title',
        'nav_list_item',
        'route',
        'nav_list_item_code',
        'slug'
    ];

    public function menu()
    {
        return $this->belongsTo(SessionNavMenuModel::class);
    }
}
