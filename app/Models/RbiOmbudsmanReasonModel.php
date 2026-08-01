<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiOmbudsmanReasonModel extends Model
{
    protected $table = 'rbi_ombudsman_reasons';
    protected $primaryKey = 'id';
    protected $allowedFields = ['reason', 'sort_order', 'status'];
    protected $useTimestamps = false;
}