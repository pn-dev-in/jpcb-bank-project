<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanProductModel;
use App\Models\LoanProductFeatureModel;
use App\Models\LoanProductDocumentModel;

class LoanProducts extends BaseController
{
    protected $model;
    protected $featureModel;
    protected $docModel;

    public function __construct()
    {
        $this->model = new LoanProductModel();
        $this->featureModel = new LoanProductFeatureModel();
        $this->docModel = new LoanProductDocumentModel();
    }

    public function index()
    {
        $products = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($products as &$p) {
            $p['features'] = $this->featureModel->where('loan_product_id', $p['id'])->orderBy('sort_order', 'asc')->findColumn('feature') ?? [];
            $p['docs'] = $this->docModel->where('loan_product_id', $p['id'])->orderBy('sort_order', 'asc')->findColumn('document') ?? [];
        }
        $data['items'] = $products;
        return view('admin/loan_products/index', $data);
    }

    public function create()
    {
        return view('admin/loan_products/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'rate'       => 'required|max_length[50]',
            'tenure'     => 'required|max_length[100]',
            'margin'     => 'required|max_length[50]',
            'security'   => 'required|max_length[255]',
            'eligibility'=> 'required',
            'features'   => 'required',
            'documents'  => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'rate'       => $this->request->getPost('rate'),
            'tenure'     => $this->request->getPost('tenure'),
            'margin'     => $this->request->getPost('margin'),
            'security'   => $this->request->getPost('security'),
            'eligibility'=> $this->request->getPost('eligibility'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        // Save features
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'loan_product_id' => $id,
                'feature'         => $feature,
                'sort_order'      => $order++,
            ]);
        }

        // Save documents
        $docs = explode("\n", str_replace("\r", "", $this->request->getPost('documents')));
        $docs = array_filter(array_map('trim', $docs));
        $order = 0;
        foreach ($docs as $doc) {
            $this->docModel->insert([
                'loan_product_id' => $id,
                'document'        => $doc,
                'sort_order'      => $order++,
            ]);
        }
        log_activity('Created', 'loan-products', $id);
        return redirect()->to('/admin/loan-products')->with('message', 'Loan product added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/loan-products')->with('error', 'Not found.');

        $features = $this->featureModel->where('loan_product_id', $id)->orderBy('sort_order', 'asc')->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));
        $docs = $this->docModel->where('loan_product_id', $id)->orderBy('sort_order', 'asc')->findAll();
        $docsText = implode("\n", array_column($docs, 'document'));

        $data['item'] = $item;
        $data['featuresText'] = $featuresText;
        $data['docsText'] = $docsText;
        return view('admin/loan_products/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'rate'       => 'required|max_length[50]',
            'tenure'     => 'required|max_length[100]',
            'margin'     => 'required|max_length[50]',
            'security'   => 'required|max_length[255]',
            'eligibility'=> 'required',
            'features'   => 'required',
            'documents'  => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'rate'       => $this->request->getPost('rate'),
            'tenure'     => $this->request->getPost('tenure'),
            'margin'     => $this->request->getPost('margin'),
            'security'   => $this->request->getPost('security'),
            'eligibility'=> $this->request->getPost('eligibility'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        // Delete old features and documents
        $this->featureModel->where('loan_product_id', $id)->delete();
        $this->docModel->where('loan_product_id', $id)->delete();

        // Save new features
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'loan_product_id' => $id,
                'feature'         => $feature,
                'sort_order'      => $order++,
            ]);
        }

        // Save new documents
        $docs = explode("\n", str_replace("\r", "", $this->request->getPost('documents')));
        $docs = array_filter(array_map('trim', $docs));
        $order = 0;
        foreach ($docs as $doc) {
            $this->docModel->insert([
                'loan_product_id' => $id,
                'document'        => $doc,
                'sort_order'      => $order++,
            ]);
        }
        log_activity('Updated', 'loan-products', $id);
        return redirect()->to('/admin/loan-products')->with('message', 'Loan product updated.');
    }

    public function delete($id)
    {
        $this->featureModel->where('loan_product_id', $id)->delete();
        $this->docModel->where('loan_product_id', $id)->delete();
        $this->model->delete($id);
        log_activity('Deleted', 'loan-products', $id);
        return redirect()->to('/admin/loan-products')->with('message', 'Loan product deleted.');
    }
}