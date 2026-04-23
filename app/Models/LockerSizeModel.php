<?php namespace App\Models; use CodeIgniter\Model;
class LockerSizeModel extends Model {
    protected $table = 'locker_sizes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['size', 'dimensions', 'rent', 'deposit', 'sort_order', 'status'];
    protected $useTimestamps = true;
}