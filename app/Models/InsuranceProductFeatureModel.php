<?php namespace App\Models; use CodeIgniter\Model;
class InsuranceProductFeatureModel extends Model {
    protected $table = 'insurance_product_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'feature', 'sort_order'];
    protected $useTimestamps = false;
}