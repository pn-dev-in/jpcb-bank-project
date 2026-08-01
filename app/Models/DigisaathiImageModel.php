<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiImageModel extends Model
{
    protected $table = 'digisaathi_images';
    protected $primaryKey = 'id';
    protected $allowedFields = ['section', 'image_path', 'alt_text', 'sort_order', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get images by section
    public function getBySection($section)
    {
        return $this->where('section', $section)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->first();
    }
    
    // Get all images grouped by section
    public function getAllGroupedBySection()
    {
        $images = $this->where('status', 1)
                      ->orderBy('sort_order', 'asc')
                      ->findAll();
        
        $grouped = [];
        foreach ($images as $image) {
            $grouped[$image['section']] = $image;
        }
        return $grouped;
    }
}