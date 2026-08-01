<?php

namespace App\Models;

use CodeIgniter\Model;

class EliteAccountFeatureModel extends Model
{
    protected $table = 'elite_account_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['elite_account_id', 'feature', 'sort_order', 'status'];

    public function getByAccountId($accountId)
    {
        return $this->where('elite_account_id', $accountId)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();
    }
}