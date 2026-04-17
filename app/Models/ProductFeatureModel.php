<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductFeatureModel extends Model
{
    protected $table            = 'product_features';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'feature', 'sort_order'];
}