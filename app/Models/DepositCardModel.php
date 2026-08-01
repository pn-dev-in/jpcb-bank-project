<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositCardModel extends Model
{
    protected $table = 'deposit_cards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'description', 'href', 'sort_order', 'status'];
    protected $useTimestamps = true;
}