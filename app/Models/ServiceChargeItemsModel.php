<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceChargeItemsModel extends Model
{
    protected $table = 'service_charge_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tab', 'section', 'type', 'label', 'charge', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}