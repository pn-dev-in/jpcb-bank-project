<?php

namespace App\Models;

use CodeIgniter\Model;

class DeafStepModel extends Model
{
    protected $table = 'deaf_steps';
    protected $primaryKey = 'id';
    protected $allowedFields = ['step_number', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}