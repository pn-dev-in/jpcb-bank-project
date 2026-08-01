<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UpiTransactionLimitModel;

class UpiTransactionLimits extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpiTransactionLimitModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/upi_transaction_limits/index', $data);
    }

    public function create()
    {
        return view('admin/upi_transaction_limits/form');
    }

    public function store()
    {
        $rules = [
            'transaction_type' => 'required|max_length[50]',
            'per_transaction'  => 'permit_empty|max_length[50]',
            'per_day_limit'    => 'permit_empty|max_length[50]',
            'per_day_count'    => 'permit_empty|max_length[20]',
            'per_month_limit'  => 'permit_empty|max_length[50]',
            'per_month_count'  => 'permit_empty|max_length[20]',
            'per_month_upi'    => 'permit_empty|max_length[20]',
            'sort_order'       => 'permit_empty|integer',
            'status'           => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'transaction_type' => $this->request->getPost('transaction_type'),
            'per_transaction'  => $this->request->getPost('per_transaction') ?? '',
            'per_day_limit'    => $this->request->getPost('per_day_limit') ?? '',
            'per_day_count'    => $this->request->getPost('per_day_count') ?? '',
            'per_month_limit'  => $this->request->getPost('per_month_limit') ?? '',
            'per_month_count'  => $this->request->getPost('per_month_count') ?? '',
            'per_month_upi'    => $this->request->getPost('per_month_upi') ?? '',
            'sort_order'       => $this->request->getPost('sort_order') ?? 0,
            'status'           => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Created', 'upi_transaction_limits', $this->model->getInsertID());
        return redirect()->to('/admin/upi-transaction-limits')->with('success', 'Limit added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/upi-transaction-limits')->with('error', 'Not found.');
        }
        return view('admin/upi_transaction_limits/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'transaction_type' => 'required|max_length[50]',
            'per_transaction'  => 'permit_empty|max_length[50]',
            'per_day_limit'    => 'permit_empty|max_length[50]',
            'per_day_count'    => 'permit_empty|max_length[20]',
            'per_month_limit'  => 'permit_empty|max_length[50]',
            'per_month_count'  => 'permit_empty|max_length[20]',
            'per_month_upi'    => 'permit_empty|max_length[20]',
            'sort_order'       => 'permit_empty|integer',
            'status'           => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'transaction_type' => $this->request->getPost('transaction_type'),
            'per_transaction'  => $this->request->getPost('per_transaction') ?? '',
            'per_day_limit'    => $this->request->getPost('per_day_limit') ?? '',
            'per_day_count'    => $this->request->getPost('per_day_count') ?? '',
            'per_month_limit'  => $this->request->getPost('per_month_limit') ?? '',
            'per_month_count'  => $this->request->getPost('per_month_count') ?? '',
            'per_month_upi'    => $this->request->getPost('per_month_upi') ?? '',
            'sort_order'       => $this->request->getPost('sort_order') ?? 0,
            'status'           => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Updated', 'upi_transaction_limits', $id);
        return redirect()->to('/admin/upi-transaction-limits')->with('success', 'Limit updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'upi_transaction_limits', $id);
        return redirect()->to('/admin/upi-transaction-limits')->with('success', 'Limit deleted.');
    }
}