<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeSliderModel extends Model
{
    protected $table = 'home_sliders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'subtitle', 'image', 'button_text', 'button_link', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;
}