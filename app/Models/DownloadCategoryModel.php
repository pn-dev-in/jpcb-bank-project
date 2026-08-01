<?php

namespace App\Models;

use CodeIgniter\Model;

class DownloadCategoryModel extends Model
{
    protected $table = 'download_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'sort_order', 'status'];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
}