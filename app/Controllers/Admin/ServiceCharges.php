<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceChargeModel;

class ServiceCharges extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ServiceChargeModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/service_charges/index', $data);
    }

    public function create()
    {
        return view('admin/service_charges/form');
    }

    public function store()
    {
        $rules = [
            'category'     => 'required|max_length[100]',
            'service_name' => 'required|max_length[255]',
            'charge'       => 'required|max_length[100]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'category'     => $this->request->getPost('category'),
            'service_name' => $this->request->getPost('service_name'),
            'charge'       => $this->request->getPost('charge'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/service-charges')->with('message', 'Service charge entry added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/service-charges')->with('error', 'Not found.');
        return view('admin/service_charges/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'category'     => 'required|max_length[100]',
            'service_name' => 'required|max_length[255]',
            'charge'       => 'required|max_length[100]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'category'     => $this->request->getPost('category'),
            'service_name' => $this->request->getPost('service_name'),
            'charge'       => $this->request->getPost('charge'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/service-charges')->with('message', 'Service charge entry updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/service-charges')->with('message', 'Service charge entry deleted.');
    }
}