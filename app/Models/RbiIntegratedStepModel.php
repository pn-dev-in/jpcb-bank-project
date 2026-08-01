<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiIntegratedStepModel extends Model
{
    protected $table = 'rbi_integrated_steps';
    protected $primaryKey = 'id';
    protected $allowedFields = ['step_number', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = false;
}