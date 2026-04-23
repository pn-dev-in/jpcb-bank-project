<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UpiBenefitModel;

class UpiBenefits extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpiBenefitModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/upi_benefits/index', $data);
    }

    public function create()
    {
        return view('admin/upi_benefits/form');
    }

    public function store()
    {
        $rules = [
            'benefit'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'benefit'    => $this->request->getPost('benefit'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/upi-benefits')->with('message', 'Benefit added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/upi-benefits')->with('error', 'Not found.');
        return view('admin/upi_benefits/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'benefit'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'benefit'    => $this->request->getPost('benefit'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/upi-benefits')->with('message', 'Benefit updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/upi-benefits')->with('message', 'Benefit deleted.');
    }
}