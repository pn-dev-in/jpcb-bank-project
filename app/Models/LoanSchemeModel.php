<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanSchemeModel extends Model
{
    protected $table = 'loan_schemes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'max_loan_amount', 'max_tenure', 'repayment', 'margin',
        'collateral_security', 'purpose', 'eligibility', 'prime_security', 'form_pdf',
        'sort_order', 'status'
    ];
    protected $useTimestamps = true;
}