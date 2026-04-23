<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiDoModel extends Model
{
    protected $table = 'rbi_dos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item', 'sort_order', 'status'];
    protected $useTimestamps = false;
}