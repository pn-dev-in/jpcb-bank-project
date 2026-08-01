<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplaintCategoryModel extends Model
{
    protected $table = 'complaint_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'sort_order', 'status'];
    protected $useTimestamps = false;
}