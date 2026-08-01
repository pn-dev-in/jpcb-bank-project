<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiServiceModel extends Model
{
    protected $table = 'digisaathi_services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['service_name', 'icon', 'sort_order', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}