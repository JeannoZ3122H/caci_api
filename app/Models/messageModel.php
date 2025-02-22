<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messageModel extends Model
{
    use HasFactory;

    protected $fileable = [
        'author_id',
        'fullname',
        'email',
        'tel',
        'profession',
        'type_procedure',
        'object',
        'requerent',
        'message',
        'file',
        'status_contact',
        'status',
        'status_answere',
        'slug'
    ];
}
