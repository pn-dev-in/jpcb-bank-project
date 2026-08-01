<?php

namespace App\Models;

use CodeIgniter\Model;

class UpiLinkingStepModel extends Model
{
    protected $table = 'upi_linking_steps';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tab', 'section',          // NEW
        'step_number', 'title', 'description',
        'sort_order', 'status'
    ];
    protected $useTimestamps = false;
}