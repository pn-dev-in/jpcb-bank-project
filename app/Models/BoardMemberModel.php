<?php namespace App\Models; use CodeIgniter\Model;
class BoardMemberModel extends Model {
    protected $table = 'board_members';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'role', 'category', 'bio', 'image', 'sort_order', 'status'];
    protected $useTimestamps = true;
}