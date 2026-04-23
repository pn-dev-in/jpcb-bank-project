<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositInterestRateModel extends Model
{
    protected $table = 'deposit_interest_rates';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tenure', 'general_rate', 'senior_rate', 'sort_order', 'status'];
    protected $useTimestamps = true;
}