<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SavingsAccountModel;
use App\Models\SavingsAccountFeatureModel;

class SavingsAccounts extends BaseController
{
    protected $model;
    protected $featureModel;

    public function __construct()
    {
        $this->model = new SavingsAccountModel();
        $this->featureModel = new SavingsAccountFeatureModel();
    }

    public function index()
    {
        $accounts = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($accounts as &$acc) {
            $acc['features'] = $this->featureModel->where('savings_account_id', $acc['id'])->orderBy('sort_order', 'asc')->findColumn('feature') ?? [];
        }
        $data['items'] = $accounts;
        return view('admin/savings_accounts/index', $data);
    }

    public function create()
    {
        return view('admin/savings_accounts/form');
    }

    public function store()
    {
        $rules = [
            'name'         => 'required|max_length[150]',
            'min_balance'  => 'required|max_length[50]',
            'interest_rate'=> 'required|max_length[20]',
            'features'     => 'required',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'name'         => $this->request->getPost('name'),
            'min_balance'  => $this->request->getPost('min_balance'),
            'interest_rate'=> $this->request->getPost('interest_rate'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'savings_account_id' => $id,
                'feature'            => $feature,
                'sort_order'         => $order++,
            ]);
        }
        $id = $this->model->getInsertID();
        log_activity('Created', 'savings-accounts', $id);
        return redirect()->to('/admin/savings-accounts')->with('message', 'Savings account added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/savings-accounts')->with('error', 'Not found.');
        $features = $this->featureModel->where('savings_account_id', $id)->orderBy('sort_order', 'asc')->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));
        $data['item'] = $item;
        $data['featuresText'] = $featuresText;
        return view('admin/savings_accounts/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'         => 'required|max_length[150]',
            'min_balance'  => 'required|max_length[50]',
            'interest_rate'=> 'required|max_length[20]',
            'features'     => 'required',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'         => $this->request->getPost('name'),
            'min_balance'  => $this->request->getPost('min_balance'),
            'interest_rate'=> $this->request->getPost('interest_rate'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        $this->featureModel->where('savings_account_id', $id)->delete();
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'savings_account_id' => $id,
                'feature'            => $feature,
                'sort_order'         => $order++,
            ]);
        }
        log_activity('Updated', 'savings-accounts', $id);
        return redirect()->to('/admin/savings-accounts')->with('message', 'Savings account updated.');
    }

    public function delete($id)
    {
        $this->featureModel->where('savings_account_id', $id)->delete();
        $this->model->delete($id);
        log_activity('Deleted', 'savings-accounts', $id);
        return redirect()->to('/admin/savings-accounts')->with('message', 'Savings account deleted.');
    }
}