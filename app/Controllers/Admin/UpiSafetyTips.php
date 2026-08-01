<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UpiSafetyTipModel;

class UpiSafetyTips extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpiSafetyTipModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/upi_safety_tips/index', $data);
    }

    public function create()
    {
        return view('admin/upi_safety_tips/form');
    }

    public function store()
    {
        $rules = [
            'tip'        => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'tip'        => $this->request->getPost('tip'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created','upi-safety-tips', $id);
        return redirect()->to('/admin/upi-safety-tips')->with('message', 'Safety tip added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/upi-safety-tips')->with('error', 'Not found.');
        return view('admin/upi_safety_tips/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'tip'        => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'tip'        => $this->request->getPost('tip'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated','upi-safety-tips', $id);
        return redirect()->to('/admin/upi-safety-tips')->with('message', 'Safety tip updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted','upi-safety-tips', $id);
        return redirect()->to('/admin/upi-safety-tips')->with('message', 'Safety tip deleted.');
    }
}