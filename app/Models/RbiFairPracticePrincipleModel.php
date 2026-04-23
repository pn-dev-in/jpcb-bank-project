<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiFairPracticePrincipleModel extends Model
{
    protected $table = 'rbi_fair_practice_principles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['principle', 'sort_order', 'status'];
    protected $useTimestamps = false;
}