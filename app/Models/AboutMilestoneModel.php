<?php namespace App\Models; use CodeIgniter\Model;
class AboutMilestoneModel extends Model {
    protected $table = 'about_milestones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}