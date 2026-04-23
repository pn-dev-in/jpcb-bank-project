<?php

namespace App\Models;

use CodeIgniter\Model;

class TickerModel extends Model
{
    protected $table = 'ticker';
    protected $primaryKey = 'id';
    protected $allowedFields = ['message', 'status'];
    protected $useTimestamps = false; // no created_at/updated_at in this table
}