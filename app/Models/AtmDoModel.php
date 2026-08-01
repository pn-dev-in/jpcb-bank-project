<?php

namespace App\Models;

use CodeIgniter\Model;

class AtmDoModel extends Model
{
    protected $table = 'atm_dos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item', 'sort_order', 'status'];
    protected $useTimestamps = true;
}