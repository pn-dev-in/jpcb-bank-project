<?php

namespace App\Models;

use CodeIgniter\Model;

class GrievanceStepModel extends Model
{
    protected $table            = 'grievance_steps';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['step', 'icon', 'title', 'description', 'timeline', 'action', 'href', 'external', 'status'];
}