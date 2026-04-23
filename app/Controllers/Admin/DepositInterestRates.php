<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepositInterestRateModel;

class DepositInterestRates extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DepositInterestRateModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/deposit_interest_rates/index', $data);
    }

    public function create()
    {
        return view('admin/deposit_interest_rates/form');
    }

    public function store()
    {
        $rules = [
            'tenure'       => 'required|max_length[100]',
            'general_rate' => 'required|max_length[10]',
            'senior_rate'  => 'required|max_length[10]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'tenure'       => $this->request->getPost('tenure'),
            'general_rate' => $this->request->getPost('general_rate'),
            'senior_rate'  => $this->request->getPost('senior_rate'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/deposit-interest-rates')->with('message', 'Interest rate added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/deposit-interest-rates')->with('error', 'Not found.');
        return view('admin/deposit_interest_rates/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'tenure'       => 'required|max_length[100]',
            'general_rate' => 'required|max_length[10]',
            'senior_rate'  => 'required|max_length[10]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'tenure'       => $this->request->getPost('tenure'),
            'general_rate' => $this->request->getPost('general_rate'),
            'senior_rate'  => $this->request->getPost('senior_rate'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/deposit-interest-rates')->with('message', 'Interest rate updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/deposit-interest-rates')->with('message', 'Interest rate deleted.');
    }
}