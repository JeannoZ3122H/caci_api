<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class SessionNavMenuModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'item_order',
        'title',
        'nav_item',
        'route',
        'nav_item_code',
        'status_nav_list',
        'slug'
    ];


    public function subMenus(): HasMany
    {
        return $this->hasMany(SessionSubNavMenuModel::class, 'nav_item_id');
    }
}
