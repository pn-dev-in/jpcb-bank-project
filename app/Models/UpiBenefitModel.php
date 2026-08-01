<?php

namespace App\Models;

use CodeIgniter\Model;

class UpiBenefitModel extends Model
{
    protected $table = 'upi_benefits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['benefit', 'sort_order', 'status'];
    protected $useTimestamps = false;
}