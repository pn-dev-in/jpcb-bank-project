<?php

namespace App\Models;

use CodeIgniter\Model;

class DigisaathiSupportFeatureModel extends Model
{
    protected $table = 'digisaathi_support_features';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'icon', 'link', 'link_text', 'sort_order', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}