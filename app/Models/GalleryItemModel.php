<?php namespace App\Models; use CodeIgniter\Model;
class GalleryItemModel extends Model {
    protected $table = 'gallery_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'category_id', 'description', 'image', 'sort_order', 'status'];
    protected $useTimestamps = true;
}