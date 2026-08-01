<?php

namespace App\Models;

use CodeIgniter\Model;

class DownloadModel extends Model
{
    protected $table = 'downloads';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'category_id',
        'file_path',
        'file_size',
        'file_type',
        'updated_date',
        'sort_order',
        'status',
        'thumbnail'
    ];
    protected $useTimestamps = true;

    public function getWithCategory()
{
    return $this->select('downloads.*, download_categories.name as category_name')
                ->join('download_categories', 'download_categories.id = downloads.category_id', 'left')
                ->findAll();
}
}