<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigitalTransactionLimitModel;

class DigitalTransactionLimits extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigitalTransactionLimitModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/digital_transaction_limits/index', $data);
    }

    public function create()
    {
        return view('admin/digital_transaction_limits/form');
    }

    public function store()
    {
        $rules = [
            'channel'      => 'required|max_length[50]',
            'description'  => 'permit_empty|max_length[255]',
            'min_per_txn'  => 'permit_empty|max_length[20]',
            'max_per_txn'  => 'permit_empty|max_length[20]',
            'max_per_day'  => 'permit_empty|max_length[20]',
            'max_per_month'=> 'permit_empty|max_length[20]',
            'per_day_count'=> 'permit_empty|max_length[20]',
            'per_month_count'=> 'permit_empty|max_length[20]',
            'availability' => 'permit_empty|max_length[50]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'channel'       => $this->request->getPost('channel'),
            'description'   => $this->request->getPost('description') ?? '',
            'min_per_txn'   => $this->request->getPost('min_per_txn') ?? '',
            'max_per_txn'   => $this->request->getPost('max_per_txn') ?? '',
            'max_per_day'   => $this->request->getPost('max_per_day') ?? '',
            'max_per_month' => $this->request->getPost('max_per_month') ?? '',
            'per_day_count' => $this->request->getPost('per_day_count') ?? '',
            'per_month_count' => $this->request->getPost('per_month_count') ?? '',
            'availability'  => $this->request->getPost('availability') ?? '00:00 to 24.00 24X7',
            'sort_order'    => $this->request->getPost('sort_order') ?? 0,
            'status'        => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Created', 'digital_transaction_limits', $this->model->getInsertID());
        return redirect()->to('/admin/digital-transaction-limits')->with('message', 'Limit added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/digital-transaction-limits')->with('error', 'Not found.');
        }
        return view('admin/digital_transaction_limits/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'channel'      => 'required|max_length[50]',
            'description'  => 'permit_empty|max_length[255]',
            'min_per_txn'  => 'permit_empty|max_length[20]',
            'max_per_txn'  => 'permit_empty|max_length[20]',
            'max_per_day'  => 'permit_empty|max_length[20]',
            'max_per_month'=> 'permit_empty|max_length[20]',
            'per_day_count'=> 'permit_empty|max_length[20]',
            'per_month_count'=> 'permit_empty|max_length[20]',
            'availability' => 'permit_empty|max_length[50]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'channel'       => $this->request->getPost('channel'),
            'description'   => $this->request->getPost('description') ?? '',
            'min_per_txn'   => $this->request->getPost('min_per_txn') ?? '',
            'max_per_txn'   => $this->request->getPost('max_per_txn') ?? '',
            'max_per_day'   => $this->request->getPost('max_per_day') ?? '',
            'max_per_month' => $this->request->getPost('max_per_month') ?? '',
            'per_day_count' => $this->request->getPost('per_day_count') ?? '',
            'per_month_count' => $this->request->getPost('per_month_count') ?? '',
            'availability'  => $this->request->getPost('availability') ?? '00:00 to 24.00 24X7',
            'sort_order'    => $this->request->getPost('sort_order') ?? 0,
            'status'        => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Updated', 'digital_transaction_limits', $id);
        return redirect()->to('/admin/digital-transaction-limits')->with('message', 'Limit updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'digital_transaction_limits', $id);
        return redirect()->to('/admin/digital-transaction-limits')->with('message', 'Limit deleted.');
    }
}