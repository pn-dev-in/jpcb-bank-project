<?php

namespace App\Models;

use CodeIgniter\Model;

class CurrentAccountModel extends Model
{
    protected $table = 'current_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'min_balance', 'sort_order', 'status'];
    protected $useTimestamps = true;
}