<?php

namespace App\Models;

use CodeIgniter\Model;

class SavingsAccountModel extends Model
{
    protected $table = 'savings_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'badge_text', 'badge_icon', 'heading', 'description',
        'min_balance_individual', 'min_balance_trust', 'min_balance_salary',
        'interest_rate', 'interest_rate_note', 'form_pdf', 'sort_order', 
        'status', 'show_in_frontend'
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