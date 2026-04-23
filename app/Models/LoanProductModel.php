<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanProductModel extends Model
{
    protected $table = 'loan_products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'rate', 'tenure', 'margin', 'security', 'eligibility', 'sort_order', 'status'];
    protected $useTimestamps = true;
}