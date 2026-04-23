<?php namespace App\Models; use CodeIgniter\Model;
class AccessibilityFeatureModel extends Model {
    protected $table = 'accessibility_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['feature', 'sort_order', 'status'];
    protected $useTimestamps = true;
}