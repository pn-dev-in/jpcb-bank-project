<?php namespace App\Models; use CodeIgniter\Model;
class ServiceChargeModel extends Model {
    protected $table = 'service_charges';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category', 'service_name', 'charge', 'sort_order', 'status'];
    protected $useTimestamps = true;
}