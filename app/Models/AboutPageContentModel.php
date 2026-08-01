<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutPageContentModel extends Model
{
    protected $table = 'about_page_content';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'hero_title',
        'hero_subtitle',
        'intro_title',
        'intro_description',
        'mission_title',
        'mission_description',
        'vision_title',
        'vision_description',
        'hero_image',
        'seo_title',
        'seo_description',
        'status',
        'sort_order',
    ];
    protected $useTimestamps = true;
}
