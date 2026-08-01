<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiDontModel extends Model
{
    protected $table = 'rbi_donts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item', 'sort_order', 'status'];
    protected $useTimestamps = false;
}