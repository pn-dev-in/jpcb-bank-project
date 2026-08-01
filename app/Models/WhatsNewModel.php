<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsNewModel extends Model
{
    protected $table = 'whats_new';
    protected $primaryKey = 'id';
    protected $allowedFields = [
    'title', 'content', 'image', 'type', 'link_text', 'link_url', 
    'sort_order', 'status', 'is_sticky', 'sticky_position', 'bg_color', 'text_color'
];
    protected $useTimestamps = true;

    public function getActiveItems($limit = null)
{
    $builder = $this->where('status', 1)->orderBy('sort_order', 'asc');
    if ($limit) {
        $builder->limit($limit);
    }
    $result = $builder->findAll();
    return is_array($result) ? $result : []; // Always return array
}

public function getStickyItems()
{
    $result = $this->where('status', 1)
                ->where('is_sticky', 1)
                ->orderBy('sort_order', 'asc')
                ->findAll();
    
    // Always return an array, even if empty
    return is_array($result) ? $result : [];
}
}