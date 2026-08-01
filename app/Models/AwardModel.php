<?php namespace App\Models; use CodeIgniter\Model;
class AwardModel extends Model {
    protected $table = 'awards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'title', 'organization', 'description', 'image', 'sort_order', 'status'];
    protected $useTimestamps = true;
}