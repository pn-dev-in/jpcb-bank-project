<?php

namespace App\Models;

use CodeIgniter\Model;

class AtmDontModel extends Model
{
    protected $table = 'atm_donts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item', 'sort_order', 'status'];
    protected $useTimestamps = true;
}