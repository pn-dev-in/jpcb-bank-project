<?php

namespace App\Models;

use CodeIgniter\Model;

class AtmServiceModel extends Model
{
    protected $table = 'atm_services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['service_name', 'icon', 'sort_order', 'status'];
    protected $useTimestamps = true;
}