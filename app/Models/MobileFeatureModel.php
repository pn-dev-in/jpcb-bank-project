<?php

namespace App\Models;

use CodeIgniter\Model;

class MobileFeatureModel extends Model
{
    protected $table = 'mobile_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['feature', 'sort_order', 'status'];
    protected $useTimestamps = false;
}