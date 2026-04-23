<?php namespace App\Models; use CodeIgniter\Model;
class InsuranceProductModel extends Model {
    protected $table = 'insurance_products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'premium', 'cover', 'eligibility', 'sort_order', 'status'];
    protected $useTimestamps = true;
}