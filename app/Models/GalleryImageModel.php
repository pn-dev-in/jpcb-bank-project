<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryImageModel extends Model
{
    protected $table = 'gallery_images';
    protected $primaryKey = 'id';
    protected $allowedFields = ['gallery_item_id', 'image_path', 'sort_order', 'status'];
    protected $useTimestamps = true;
}