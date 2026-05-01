<?php

namespace App\Models;

use CodeIgniter\Model;

class BranchModel extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id';

    protected $allowedFields = [
    'branch_name', 'centre_name', 'address', 'area', 'city', 'district', 'sub_district',
    'pincode', 'state', 'ifsc', 'micr', 'branch_code', 'bank_category',
    'latitude', 'longitude', 'phone', 'telephone_alt', 'email', 'timings',
    'services', 'has_atm', 'status'
];

     protected $useTimestamps = true;
}
