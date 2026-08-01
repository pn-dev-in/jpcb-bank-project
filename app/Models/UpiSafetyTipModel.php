<?php

namespace App\Models;

use CodeIgniter\Model;

class UpiSafetyTipModel extends Model
{
    protected $table = 'upi_safety_tips';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tip', 'sort_order', 'status'];
    protected $useTimestamps = false;
}