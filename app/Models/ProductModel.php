<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'category', 'icon', 'href', 'sort_order', 'status',
        'intro', 'benefits', 'cta_apply', 'cta_details', 'cta_target', 'image_alt'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get active products with their features (ordered)
    public function getProductsWithFeatures()
    {
        $products = $this->where('status', 1)->orderBy('sort_order', 'asc')->findAll();

        $featureModel = new ProductFeatureModel();
        foreach ($products as &$product) {
            $features = $featureModel->where('product_id', $product['id'])
                ->orderBy('sort_order', 'asc')
                ->findAll();
            $product['features'] = array_column($features, 'feature');
            
            // Decode benefits from pipe-separated string to array
            if (!empty($product['benefits'])) {
                $product['benefits'] = explode('|', $product['benefits']);
            } else {
                $product['benefits'] = [];
            }
        }
        return $products;
    }
    
    // Get all products with features for admin
    public function getAllProductsWithFeatures()
    {
        $products = $this->orderBy('sort_order', 'asc')->findAll();
        
        $featureModel = new ProductFeatureModel();
        foreach ($products as &$product) {
            $features = $featureModel->where('product_id', $product['id'])
                ->orderBy('sort_order', 'asc')
                ->findAll();
            $product['features_list'] = array_column($features, 'feature');
        }
        return $products;
    }
}