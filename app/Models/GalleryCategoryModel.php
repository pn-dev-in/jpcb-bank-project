<?php namespace App\Models; use CodeIgniter\Model;
class GalleryCategoryModel extends Model {
    protected $table = 'gallery_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'sort_order', 'status'];
    protected $useTimestamps = true;
}