<?php

namespace App\Models;

use CodeIgniter\Model;

class MobileFaqModel extends Model
{
    protected $table = 'mobile_faqs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['question', 'answer', 'sort_order', 'status'];
    protected $useTimestamps = true;
}