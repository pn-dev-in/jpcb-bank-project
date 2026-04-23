<?php

namespace App\Models;

use CodeIgniter\Model;

class CurrentAccountFeatureModel extends Model
{
    protected $table = 'current_account_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['current_account_id', 'feature', 'sort_order'];
    protected $useTimestamps = false;
}