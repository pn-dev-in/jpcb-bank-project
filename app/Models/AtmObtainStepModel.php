<?php

namespace App\Models;

use CodeIgniter\Model;

class AtmObtainStepModel extends Model
{
    protected $table = 'atm_obtain_steps';
    protected $primaryKey = 'id';
    protected $allowedFields = ['step_number', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}