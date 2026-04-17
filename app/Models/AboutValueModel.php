<?php namespace App\Models; use CodeIgniter\Model;
class AboutValueModel extends Model {
    protected $table = 'about_values';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}