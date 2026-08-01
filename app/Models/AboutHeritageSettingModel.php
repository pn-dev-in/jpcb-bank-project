<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutHeritageSettingModel extends Model
{
    protected $table = 'about_heritage_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'eyebrow',
        'title',
        'subheading_left',
        'heading_left',
        'image',
        'intro_paragraph',
        'founding_paragraph',
        'expandable_paragraphs'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get the single settings record (id = 1)
     */
    public function getSettings()
    {
        $settings = $this->find(1);
        if (!$settings) {
            // fallback – create default record if missing
            $default = [
                'eyebrow' => 'Heritage & Legacy',
                'title' => 'People Tree to Bodhi Tree',
                'subheading_left' => 'Eternal Bond of Trust',
                'heading_left' => 'A Banyan Rooted in 1933',
                'image' => null,
                'intro_paragraph' => '',
                'founding_paragraph' => '',
                'expandable_paragraphs' => ''
            ];
            $this->insert($default);
            $settings = $this->find(1);
        }
        return $settings;
    }
}