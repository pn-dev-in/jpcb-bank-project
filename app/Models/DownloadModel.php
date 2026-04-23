<?php

namespace App\Models;

use CodeIgniter\Model;

class DownloadModel extends Model
{
    protected $table = 'downloads';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'category',
        'file_path',
        'file_size',
        'file_type',
        'updated_date',
        'sort_order',
        'status'
    ];
    protected $useTimestamps = true;
}