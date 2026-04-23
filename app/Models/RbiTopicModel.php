<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiTopicModel extends Model
{
    protected $table = 'rbi_topics';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'description', 'href', 'sort_order', 'status'];
    protected $useTimestamps = true;
}