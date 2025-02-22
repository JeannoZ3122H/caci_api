<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionFooterSubMenuModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'nav_footer_item_id',
        'item_order',
        'nav_list_footer_item',
        'nav_list_footer_item_code',
        'nav_list_footer_item_icon',
        'nav_list_footer_item_type_content',
        'nav_list_footer_item_content',
        'slug'
    ];


    public function menu()
    {
        return $this->belongsTo(SessionFooterMenuModel::class);
    }
}
