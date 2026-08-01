<?php namespace App\Models; use CodeIgniter\Model;
class ServiceCardModel extends Model {
    protected $table = 'service_cards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'description', 'href', 'sort_order', 'status'];
    protected $useTimestamps = true;
}