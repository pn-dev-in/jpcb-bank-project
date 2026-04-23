<?php namespace App\Models; use CodeIgniter\Model;
class PrivacyPolicySectionModel extends Model {
    protected $table = 'privacy_policy_sections';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'sort_order', 'status'];
    protected $useTimestamps = true;
}