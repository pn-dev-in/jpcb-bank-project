<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositProductFeatureModel extends Model
{
    protected $table = 'deposit_product_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'feature', 'sort_order'];
    protected $useTimestamps = false;
}