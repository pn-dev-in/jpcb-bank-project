<?php

namespace App\Models;

use CodeIgniter\Model;

class InsurancePlanModel extends Model
{
    protected $table = 'insurance_plans';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tab', 'category', 'plan_name', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}