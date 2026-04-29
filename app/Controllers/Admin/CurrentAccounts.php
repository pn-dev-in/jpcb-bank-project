<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CurrentAccountModel;
use App\Models\CurrentAccountFeatureModel;

class CurrentAccounts extends BaseController
{
    protected $model;
    protected $featureModel;

    public function __construct()
    {
        $this->model = new CurrentAccountModel();
        $this->featureModel = new CurrentAccountFeatureModel();
    }

    public function index()
    {
        $accounts = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($accounts as &$acc) {
            $acc['features'] = $this->featureModel->where('current_account_id', $acc['id'])->orderBy('sort_order', 'asc')->findColumn('feature') ?? [];
        }
        $data['items'] = $accounts;
        return view('admin/current_accounts/index', $data);
    }

    public function create()
    {
        return view('admin/current_accounts/form');
    }

    public function store()
    {
        $rules = [
            'name'        => 'required|max_length[150]',
            'min_balance' => 'required|max_length[50]',
            'features'    => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'name'        => $this->request->getPost('name'),
            'min_balance' => $this->request->getPost('min_balance'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'current_account_id' => $id,
                'feature'            => $feature,
                'sort_order'         => $order++,
            ]);
        }
        $id = $this->model->getInsertID();
        log_activity('Created', 'current_accounts', $id);
        return redirect()->to('/admin/current-accounts')->with('message', 'Current account added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/current-accounts')->with('error', 'Not found.');
        $features = $this->featureModel->where('current_account_id', $id)->orderBy('sort_order', 'asc')->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));
        $data['item'] = $item;
        $data['featuresText'] = $featuresText;
        return view('admin/current_accounts/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'        => 'required|max_length[150]',
            'min_balance' => 'required|max_length[50]',
            'features'    => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'        => $this->request->getPost('name'),
            'min_balance' => $this->request->getPost('min_balance'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        $this->featureModel->where('current_account_id', $id)->delete();
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'current_account_id' => $id,
                'feature'            => $feature,
                'sort_order'         => $order++,
            ]);
        }
        log_activity('Updated', 'current_accounts', $id);
        return redirect()->to('/admin/current-accounts')->with('message', 'Current account updated.');
    }

    public function delete($id)
    {
        $this->featureModel->where('current_account_id', $id)->delete();
        $this->model->delete($id);
        log_activity('Deleted', 'current_accounts', $id);
        return redirect()->to('/admin/current-accounts')->with('message', 'Current account deleted.');
    }
}