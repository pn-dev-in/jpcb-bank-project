<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplyPanelItemModel extends Model
{
    protected $table = 'apply_panel_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'icon', 'label', 'link', 'color', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;
    
    public function getActiveItems()
    {
        return $this->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();
    }
    
    public function getColors()
    {
        return [
            'green' => 'Green (Primary)',
            'teal' => 'Teal (Secondary)',
            'gold' => 'Gold (Accent)',
            'blue' => 'Blue',
            'purple' => 'Purple',
            'red' => 'Red (Destructive)',
            'orange' => 'Orange',
            'pink' => 'Pink'
        ];
    }
}