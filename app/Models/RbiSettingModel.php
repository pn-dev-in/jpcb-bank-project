<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiSettingModel extends Model
{
    protected $table = 'rbi_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'value'];
    protected $useTimestamps = true;
}