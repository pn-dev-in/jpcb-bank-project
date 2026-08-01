<?php

namespace App\Models;

use CodeIgniter\Model;

class CareerApplicationModel extends Model
{
    protected $table = 'career_applications';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'resume'
    ];
}