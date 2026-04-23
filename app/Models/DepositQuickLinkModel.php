<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositQuickLinkModel extends Model
{
    protected $table = 'deposit_quick_links';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'label', 'href', 'sort_order', 'status'];
    protected $useTimestamps = true;
}