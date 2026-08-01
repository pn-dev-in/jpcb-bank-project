<?php

namespace App\Models;

use CodeIgniter\Model;

class AtmGuidelineModel extends Model
{
    protected $table = 'atm_guidelines';
    protected $primaryKey = 'id';
    protected $allowedFields = ['guideline', 'sort_order', 'status'];
    protected $useTimestamps = true;
}