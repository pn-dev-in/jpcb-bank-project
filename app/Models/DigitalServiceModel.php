<?php

namespace App\Models;

use CodeIgniter\Model;

class DigitalServiceModel extends Model
{
    protected $table = 'digital_services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'description', 'href', 'sort_order', 'status'];
    protected $useTimestamps = true;
}