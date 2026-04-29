<?php

namespace App\Models;

use CodeIgniter\Model;

class AtmLocationModel extends Model
{
    protected $table = 'atm_locations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'city', 'area', 'pin', 'hours', 'atm_status', 'sort_order', 'status',  'unique_id'];
    protected $useTimestamps = true;
}