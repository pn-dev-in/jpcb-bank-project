<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiContactModel extends Model
{
    protected $table = 'digisaathi_contacts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'subtitle', 'button_text', 'button_color', 'type', 'link', 'image', 'is_external', 'sort_order', 'status'];
    protected $useTimestamps = false;
}