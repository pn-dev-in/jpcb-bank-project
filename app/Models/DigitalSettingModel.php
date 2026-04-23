<?php

namespace App\Models;

use CodeIgniter\Model;

class DigitalSettingModel extends Model
{
    protected $table = 'digital_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'value'];
    protected $useTimestamps = true;
}