<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplyPanelSettingModel extends Model
{
    protected $table = 'apply_panel_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'is_enabled', 'panel_title', 'panel_subtitle', 
        'footer_text', 'footer_link', 'button_text', 'position'
    ];
    protected $useTimestamps = true;
    
    public function getSettings()
    {
        $settings = $this->find(1);
        if (!$settings) {
            $settings = [
                'is_enabled' => 1,
                'panel_title' => 'Quick Apply',
                'panel_subtitle' => 'Open an account instantly',
                'footer_text' => 'Talk to an advisor',
                'footer_link' => '/contact',
                'button_text' => 'Apply Now',
                'position' => 'left'
            ];
        }
        return $settings;
    }
}