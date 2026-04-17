<?php

namespace App\Models;

use CodeIgniter\Model;

class BranchModel extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'branch_name',
        'address',
        'area',
        'city',
        'pincode',
        'ifsc',
        'micr',
        'phone',
        'timings',
        'services',
        'has_atm'
    ];

     protected $useTimestamps = true;
}
