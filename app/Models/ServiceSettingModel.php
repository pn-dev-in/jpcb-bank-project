<?php namespace App\Models; use CodeIgniter\Model;
class ServiceSettingModel extends Model {
    protected $table = 'service_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'value'];
    protected $useTimestamps = true;
}