<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositProductModel extends Model
{
    protected $table = 'deposit_products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'tenure', 'min_amount', 'interest_rate', 'payout', 'form_pdf', 'sort_order', 'status'];
    protected $useTimestamps = true;
}