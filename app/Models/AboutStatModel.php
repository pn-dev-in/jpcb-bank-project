<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutStatModel extends Model
{
    protected $table = 'about_stats';
    protected $primaryKey = 'id';
    protected $allowedFields = ['number', 'label', 'sort_order', 'status'];
    protected $useTimestamps = true;
}