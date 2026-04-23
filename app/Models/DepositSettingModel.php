<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositSettingModel extends Model
{
    protected $table = 'deposit_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'value'];
    protected $useTimestamps = true;
}