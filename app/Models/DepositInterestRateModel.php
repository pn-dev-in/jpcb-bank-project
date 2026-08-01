<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositInterestRateModel extends Model
{
    protected $table = 'deposit_interest_rates';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenure', 'scheme_type', 'scheme_name', 'amount_slab', 
        'general_rate', 'senior_rate', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get rates grouped by scheme type
    public function getRatesGrouped()
    {
        $rates = $this->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        $grouped = [];
        foreach ($rates as $rate) {
            $grouped[$rate['scheme_type']][] = $rate;
        }
        return $grouped;
    }
    
    // Get rates for normal schemes by amount slab
    public function getNormalRatesBySlab($slab = 'below_1cr')
    {
        return $this->where('status', 1)
                    ->where('scheme_type', 'normal')
                    ->where('amount_slab', $slab)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();
    }
}