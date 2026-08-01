<?php
namespace App\Models;
use CodeIgniter\Model;

class UpiItemModel extends Model
{
    protected $table = 'upi_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tab', 'section', 'type', 'icon', 'title', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}