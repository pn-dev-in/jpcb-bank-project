<?php namespace App\Models; use CodeIgniter\Model;
class ManagementTeamModel extends Model {
    protected $table = 'management_team';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'role', 'department', 'bio', 'sort_order', 'status'];
    protected $useTimestamps = true;
}