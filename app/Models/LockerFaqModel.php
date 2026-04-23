<?php namespace App\Models; use CodeIgniter\Model;
class LockerFaqModel extends Model {
    protected $table = 'locker_faqs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['question', 'answer', 'sort_order', 'status'];
    protected $useTimestamps = true;
}