<?php

namespace App\Models;

use CodeIgniter\Model;

class BlockCardAfterStepModel extends Model
{
    protected $table = 'block_card_after_steps';
    protected $primaryKey = 'id';
    protected $allowedFields = ['step', 'sort_order', 'status'];
    protected $useTimestamps = false;
}