<?php

namespace App\Models;

use CodeIgniter\Model;

class BlockCardMethodModel extends Model
{
    protected $table = 'block_card_methods';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = false;
}