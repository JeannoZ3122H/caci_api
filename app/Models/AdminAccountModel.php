<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccountModel extends Model
{
    use HasFactory;
    protected $fileable = [
        'role_id',
        'fname',
        'admin_img',
        'lname',
        'fonction',
        'phone',
        'email',
        'reset_password',
        'status_account',
        'slug'
    ];
}
