<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class analyseFolderModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'folder_us_id',
        'object',
        'comments',
        'current_step',
        'next_step',
        'next_step_date',
        'status_analyse',
        'slug'
    ];



    public function folder()
    {
        return $this->belongsTo(FolderUsModel::class);
    }
}
