<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamsModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'author_id',
        'item_order',
        'pays_id',
        'fname',
        'lname',
        'matricule',
        'person_img',
        'profession_list',
        'phone',
        'competences',
        'fonctions',
        'email',
        'address',
        'genre',
        'languages',
        'nationnalite',
        'lieu_residence',
        'organisation',
        'link_linkedin',
        'link_site_web',
        'category_person',
        'slug'
    ];
}
