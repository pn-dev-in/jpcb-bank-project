<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiBookletTopicModel extends Model
{
    protected $table = 'rbi_booklet_topics';
    protected $primaryKey = 'id';
    protected $allowedFields = ['topic', 'sort_order', 'status'];
    protected $useTimestamps = false;
}