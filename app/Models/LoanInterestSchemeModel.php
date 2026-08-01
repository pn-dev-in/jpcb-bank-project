<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanInterestSchemeModel extends Model
{
    protected $table = 'loan_interest_schemes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category', 'serial_no', 'scheme_name', 'min_roi', 'max_roi',
        'women_benefit', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;
}