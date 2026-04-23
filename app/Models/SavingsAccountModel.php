<?php

namespace App\Models;

use CodeIgniter\Model;

class SavingsAccountModel extends Model
{
    protected $table = 'savings_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'min_balance', 'interest_rate', 'sort_order', 'status'];
    protected $useTimestamps = true;
}