<?php

namespace App\Models;

use CodeIgniter\Model;

class MobileBankingEligibilityModel extends Model
{
    protected $table = 'mobile_banking_eligibility';
    protected $primaryKey = 'id';
    protected $allowedFields = ['account_type', 'constitution', 'mode_of_operation', 'eligible', 'sort_order', 'status'];
    protected $useTimestamps = true;
}