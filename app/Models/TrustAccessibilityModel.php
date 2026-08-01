<?php

namespace App\Models;

use CodeIgniter\Model;

class TrustAccessibilityModel extends Model
{
    protected $table            = 'trust_accessibility';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['heading', 'description', 'button_text', 'button_link'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}