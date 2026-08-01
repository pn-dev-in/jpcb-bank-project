<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiSettingModel extends Model
{
    protected $table = 'digisaathi_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'value', 'type', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}