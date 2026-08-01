<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InsuranceProductModel;
use App\Models\InsuranceProductFeatureModel;

class InsuranceProducts extends BaseController
{
    protected $model;
    protected $featureModel;

    public function __construct()
    {
        $this->model = new InsuranceProductModel();
        $this->featureModel = new InsuranceProductFeatureModel();
    }

    public function index()
    {
        $products = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($products as &$p) {
            $p['features'] = $this->featureModel->where('product_id', $p['id'])->orderBy('sort_order', 'asc')->findColumn('feature') ?? [];
        }
        $data['items'] = $products;
        return view('admin/insurance_products/index', $data);
    }

    public function create()
    {
        return view('admin/insurance_products/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[255]',
            'premium'    => 'required|max_length[50]',
            'cover'      => 'required|max_length[100]',
            'eligibility'=> 'required|max_length[255]',
            'features'   => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'premium'    => $this->request->getPost('premium'),
            'cover'      => $this->request->getPost('cover'),
            'eligibility'=> $this->request->getPost('eligibility'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

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
        log_activity('Created', 'insurance-products', $id);
        return redirect()->to('/admin/insurance-products')->with('message', 'Insurance product added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/insurance-products')->with('error', 'Not found.');
        $features = $this->featureModel->where('product_id', $id)->orderBy('sort_order', 'asc')->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));
        $data['item'] = $item;
        $data['featuresText'] = $featuresText;
        return view('admin/insurance_products/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[255]',
            'premium'    => 'required|max_length[50]',
            'cover'      => 'required|max_length[100]',
            'eligibility'=> 'required|max_length[255]',
            'features'   => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'premium'    => $this->request->getPost('premium'),
            'cover'      => $this->request->getPost('cover'),
            'eligibility'=> $this->request->getPost('eligibility'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

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
        log_activity('Updated', 'insurance-products', $id);
        return redirect()->to('/admin/insurance-products')->with('message', 'Insurance product updated.');
    }

    public function delete($id)
    {
        $this->featureModel->where('product_id', $id)->delete();
        $this->model->delete($id);
        log_activity('Deleted', 'insurance-products', $id);
        return redirect()->to('/admin/insurance-products')->with('message', 'Insurance product deleted.');
    }
}