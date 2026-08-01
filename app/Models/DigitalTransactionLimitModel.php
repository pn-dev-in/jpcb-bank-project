<?php

namespace App\Models;

use CodeIgniter\Model;

class DigitalTransactionLimitModel extends Model
{
    protected $table = 'digital_transaction_limits';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'channel', 'description', 'min_per_txn', 'max_per_txn',
        'max_per_day', 'max_per_month', 'per_day_count', 'per_month_count',
        'availability', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;
}