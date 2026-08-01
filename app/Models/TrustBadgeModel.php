<?php

namespace App\Models;

use CodeIgniter\Model;

class TrustBadgeModel extends Model
{
    protected $table            = 'trust_badges';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['icon', 'label', 'color_class', 'sort_order', 'status'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}