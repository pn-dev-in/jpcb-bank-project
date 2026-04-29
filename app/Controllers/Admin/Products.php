<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductFeatureModel;

class Products extends BaseController
{
    protected $productModel;
    protected $featureModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->featureModel = new ProductFeatureModel();
    }

    public function index()
    {
        $products = $this->productModel->orderBy('sort_order', 'asc')->findAll();
        foreach ($products as &$p) {
            $features = $this->featureModel->where('product_id', $p['id'])->orderBy('sort_order', 'asc')->findAll();
            $p['features_list'] = array_column($features, 'feature');
        }
        return view('admin/products/index', ['products' => $products]);
    }

    public function create()
    {
        return view('admin/products/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'icon'       => 'required|max_length[50]',
            'href'       => 'required|max_length[100]',
            'category'   => 'permit_empty|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
            'features'   => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = $this->productModel->insert([
            'name'       => $this->request->getPost('name'),
            'icon'       => $this->request->getPost('icon'),
            'href'       => $this->request->getPost('href'),
            'category'   => $this->request->getPost('category'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        // Insert features
        $featuresText = $this->request->getPost('features');
        $features = explode("\n", str_replace("\r", "", $featuresText));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'product_id' => $productId,
                'feature'    => $feature,
                'sort_order' => $order++,
            ]);
        }
        log_activity('Created', 'products', $productId);
        return redirect()->to('/admin/products')->with('message', 'Product created.');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found.');
        }
        $features = $this->featureModel->where('product_id', $id)->orderBy('sort_order', 'asc')->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));
        return view('admin/products/form', ['product' => $product, 'featuresText' => $featuresText]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'icon'       => 'required|max_length[50]',
            'href'       => 'required|max_length[100]',
            'category'   => 'permit_empty|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
            'features'   => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->update($id, [
            'name'       => $this->request->getPost('name'),
            'icon'       => $this->request->getPost('icon'),
            'href'       => $this->request->getPost('href'),
            'category'   => $this->request->getPost('category'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        // Delete old features and insert new ones
        $this->featureModel->where('product_id', $id)->delete();
        $featuresText = $this->request->getPost('features');
        $features = explode("\n", str_replace("\r", "", $featuresText));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'product_id' => $id,
                'feature'    => $feature,
                'sort_order' => $order++,
            ]);
        }
        log_activity('Updated', 'products', $id);
        return redirect()->to('/admin/products')->with('message', 'Product updated.');
    }

    public function delete($id)
    {
        $this->featureModel->where('product_id', $id)->delete();
        $this->productModel->delete($id);
        log_activity('Deleted', 'products', $id);
        return redirect()->to('/admin/products')->with('message', 'Product deleted.');
    }
}