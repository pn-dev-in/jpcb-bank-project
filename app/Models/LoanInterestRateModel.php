<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanInterestRateModel extends Model
{
    protected $table = 'loan_interest_rates';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_name', 'rate', 'processing_fee', 'prepayment_charge', 'sort_order', 'status'];
    protected $useTimestamps = true;
}