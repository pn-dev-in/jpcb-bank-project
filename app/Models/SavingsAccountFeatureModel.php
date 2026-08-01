<?php

namespace App\Models;

use CodeIgniter\Model;

class SavingsAccountFeatureModel extends Model
{
    protected $table = 'savings_account_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['savings_account_id', 'feature', 'sort_order', 'status'];

    public function getByAccountId($accountId)
    {
        return $this->where('savings_account_id', $accountId)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();
    }
}