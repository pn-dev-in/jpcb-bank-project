<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeHeroModel extends Model
{
    protected $table            = 'home_hero';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'badge_text', 'heading_main', 'heading_highlight', 'description',
        'button1_text', 'button1_link', 'button2_text', 'button2_link',
        'search_placeholder'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}