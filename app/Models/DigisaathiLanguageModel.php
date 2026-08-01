<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiLanguageModel extends Model
{
    protected $table = 'digisaathi_languages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'sort_order', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}