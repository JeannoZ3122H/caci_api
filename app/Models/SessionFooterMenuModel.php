<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SessionFooterMenuModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'item_order',
        'nav_footer_item_code',
        'nav_footer_item',
        'perimetre',
        'slug'
    ];

    public function subMenus(): HasMany
    {
        return $this->hasMany(SessionFooterSubMenuModel::class, 'nav_footer_item_id');
    }
}
