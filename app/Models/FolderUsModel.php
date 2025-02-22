<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FolderUsModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'type_procedure_id',
        'ref_folder',
        'fullname',
        'dossier_follower',
        'email',
        'tel',
        'professions',
        'description',
        'file',
        'already_step',
        'status_folder_analyse',
        'status_finished',
        'status_answere',
        'slug'
    ];



    public function analyse(): HasMany
    {
        return $this->hasMany(analyseFolderModel::class, 'folder_us_id');
    }
}
