<?php

namespace App\Models;

use CodeIgniter\Model;

class QuickActionModel extends Model
{
    protected $table            = 'quick_actions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'icon', 'link', 'is_alert', 'status'];

    protected $useTimestamps = false; // Your table doesn't have created_at/updated_at
}