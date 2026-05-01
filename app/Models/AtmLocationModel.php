<?php

namespace App\Models;

use CodeIgniter\Model;

class AtmLocationModel extends Model
{
    protected $table = 'atm_locations';
    protected $primaryKey = 'id';
     protected $allowedFields = [
        'unique_id', 'name', 'address', 'city', 'area', 'pin',
        'latitude', 'longitude', 'hours', 'location_type',
        'atm_status', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;
}