<?php

namespace App\Models;

use CodeIgniter\Model;

class MobileRegistrationStepModel extends Model
{
    protected $table = 'mobile_registration_steps';
    protected $primaryKey = 'id';
    protected $allowedFields = ['step_number', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = false;
}