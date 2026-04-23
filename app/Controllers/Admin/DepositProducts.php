<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepositProductModel;
use App\Models\DepositProductFeatureModel;

class DepositProducts extends BaseController
{
    protected $model;
    protected $featureModel;

    public function __construct()
    {
        $this->model = new DepositProductModel();
        $this->featureModel = new DepositProductFeatureModel();
    }

    public function index()
    {
        $products = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($products as &$product) {
            $product['features'] = $this->featureModel->where('product_id', $product['id'])->orderBy('sort_order', 'asc')->findColumn('feature') ?? [];
        }
        $data['items'] = $products;
        return view('admin/deposit_products/index', $data);
    }

    public function create()
    {
        return view('admin/deposit_products/form');
    }

    public function store()
    {
        $rules = [
            'name'         => 'required|max_length[150]',
            'tenure'       => 'required|max_length[100]',
            'min_amount'   => 'required|max_length[50]',
            'interest_rate'=> 'required|max_length[50]',
            'payout'       => 'required|max_length[100]',
            'features'     => 'required',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'name'         => $this->request->getPost('name'),
            'tenure'       => $this->request->getPost('tenure'),
            'min_amount'   => $this->request->getPost('min_amount'),
            'interest_rate'=> $this->request->getPost('interest_rate'),
            'payout'       => $this->request->getPost('payout'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        // Save features
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'product_id' => $id,
                'feature'    => $feature,
                'sort_order' => $order++,
            ]);
        }

        return redirect()->to('/admin/deposit-products')->with('message', 'Deposit product added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/deposit-products')->with('error', 'Not found.');
        $features = $this->featureModel->where('product_id', $id)->orderBy('sort_order', 'asc')->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));
        $data['item'] = $item;
        $data['featuresText'] = $featuresText;
        return view('admin/deposit_products/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'         => 'required|max_length[150]',
            'tenure'       => 'required|max_length[100]',
            'min_amount'   => 'required|max_length[50]',
            'interest_rate'=> 'required|max_length[50]',
            'payout'       => 'required|max_length[100]',
            'features'     => 'required',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'         => $this->request->getPost('name'),
            'tenure'       => $this->request->getPost('tenure'),
            'min_amount'   => $this->request->getPost('min_amount'),
            'interest_rate'=> $this->request->getPost('interest_rate'),
            'payout'       => $this->request->getPost('payout'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        // Replace features
        $this->featureModel->where('product_id', $id)->delete();
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'product_id' => $id,
                'feature'    => $feature,
                'sort_order' => $order++,
            ]);
        }

        return redirect()->to('/admin/deposit-products')->with('message', 'Deposit product updated.');
    }

    public function delete($id)
    {
        $this->featureModel->where('product_id', $id)->delete();
        $this->model->delete($id);
        return redirect()->to('/admin/deposit-products')->with('message', 'Deposit product deleted.');
    }
}