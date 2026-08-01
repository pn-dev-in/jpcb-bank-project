<?php

namespace App\Models;

use CodeIgniter\Model;

class DicgcFaqModel extends Model
{
    protected $table = 'dicgc_faqs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['question', 'answer', 'sort_order', 'status'];
    protected $useTimestamps = true;
}