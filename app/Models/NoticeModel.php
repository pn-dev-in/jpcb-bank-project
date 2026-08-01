<?php

namespace App\Models;

use CodeIgniter\Model;

class NoticeModel extends Model
{
    protected $table = 'notices';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title', 'description', 'type', 'date',
        'status', 'sort_order',
        'file_path', 'external_link'
    ];
}