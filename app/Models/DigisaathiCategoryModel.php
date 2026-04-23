<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiCategoryModel extends Model
{
    protected $table = 'digisaathi_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = false;
}