<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiContactModel extends Model
{
    protected $table = 'digisaathi_contacts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'subtitle', 'link', 'is_external', 'sort_order', 'status'];
    protected $useTimestamps = false;
}