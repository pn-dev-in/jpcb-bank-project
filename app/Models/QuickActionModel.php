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
    protected $allowedFields    = ['title', 'description', 'icon', 'link', 'image', 'is_alert', 'status'];

    // Get active quick actions for frontend
    public function getActiveQuickActions()
    {
        return $this->where('status', 1)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }
}