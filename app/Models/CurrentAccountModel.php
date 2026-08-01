<?php

namespace App\Models;

use CodeIgniter\Model;

class CurrentAccountModel extends Model
{
    protected $table = 'current_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'badge_text', 'badge_icon', 'heading', 'description',
        'min_balance', 'form_pdf', 'sort_order', 'status', 'show_in_frontend'
    ];
    protected $useTimestamps = true;

    public function getActiveForFrontend()
    {
        return $this->where('status', 1)
                    ->where('show_in_frontend', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();
    }
}