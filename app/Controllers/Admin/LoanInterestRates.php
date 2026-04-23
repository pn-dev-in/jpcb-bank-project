<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanInterestRateModel;

class LoanInterestRates extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LoanInterestRateModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/loan_interest_rates/index', $data);
    }

    public function create()
    {
        return view('admin/loan_interest_rates/form');
    }

    public function store()
    {
        $rules = [
            'product_name'      => 'required|max_length[150]',
            'rate'              => 'required|max_length[50]',
            'processing_fee'    => 'required|max_length[50]',
            'prepayment_charge' => 'required|max_length[50]',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'product_name'      => $this->request->getPost('product_name'),
            'rate'              => $this->request->getPost('rate'),
            'processing_fee'    => $this->request->getPost('processing_fee'),
            'prepayment_charge' => $this->request->getPost('prepayment_charge'),
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/loan-interest-rates')->with('message', 'Interest rate entry added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/loan-interest-rates')->with('error', 'Not found.');
        return view('admin/loan_interest_rates/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'product_name'      => 'required|max_length[150]',
            'rate'              => 'required|max_length[50]',
            'processing_fee'    => 'required|max_length[50]',
            'prepayment_charge' => 'required|max_length[50]',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'product_name'      => $this->request->getPost('product_name'),
            'rate'              => $this->request->getPost('rate'),
            'processing_fee'    => $this->request->getPost('processing_fee'),
            'prepayment_charge' => $this->request->getPost('prepayment_charge'),
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/loan-interest-rates')->with('message', 'Interest rate entry updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/loan-interest-rates')->with('message', 'Interest rate entry deleted.');
    }
}