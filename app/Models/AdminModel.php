<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'employee_id',
        'email',
        'password',
        'profile_image',
        'gender',
        'role_id',
        'is_active',
        'last_login',      // add this
        'failed_attempts'  // add this
    ];
}