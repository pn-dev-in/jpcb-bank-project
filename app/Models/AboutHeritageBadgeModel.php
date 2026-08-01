<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutHeritageBadgeModel extends Model
{
    protected $table = 'about_heritage_badges';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'icon',
        'label',
        'description',
        'color_theme',
        'sort_order',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all active badges, sorted by sort_order
     */
    public function getActiveBadges()
    {
        return $this->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->findAll();
    }

    /**
     * Get all badges (admin) sorted by sort_order
     */
    public function getAllBadges()
    {
        return $this->orderBy('sort_order', 'asc')->findAll();
    }
}