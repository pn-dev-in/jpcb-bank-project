<?php

namespace App\Models;

use CodeIgniter\Model;

class TrustCardModel extends Model
{
    protected $table            = 'trust_cards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'icon_name', 'title', 'description', 'link', 'sort_order', 'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}