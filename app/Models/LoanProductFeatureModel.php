<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanProductFeatureModel extends Model
{
    protected $table = 'loan_product_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['loan_product_id', 'feature', 'sort_order'];
    protected $useTimestamps = false;
}