<?php

namespace App\Models;

use CodeIgniter\Model;

class SafetySectionSettingsModel extends Model
{
    protected $table            = 'safety_section_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'heading', 'warning_text', 'description',
        'button1_text', 'button1_link',
        'button2_text', 'button2_link',
        'button3_text', 'button3_link'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}