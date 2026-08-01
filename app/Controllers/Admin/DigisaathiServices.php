<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigisaathiServiceModel;

class DigisaathiServices extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigisaathiServiceModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/digisaathi_services/index', $data);
    }

    public function create()
    {
        return view('admin/digisaathi_services/form');
    }

    public function store()
    {
        $rules = [
            'service_name' => 'required|max_length[150]',
            'icon'         => 'permit_empty|max_length[50]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'service_name' => $this->request->getPost('service_name'),
            'icon'         => $this->request->getPost('icon') ?? 'check',
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'digisaathi-services', $id);
        return redirect()->to('/admin/digisaathi-services')->with('message', 'Service added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/digisaathi-services')->with('error', 'Not found.');
        return view('admin/digisaathi_services/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'service_name' => 'required|max_length[150]',
            'icon'         => 'permit_empty|max_length[50]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'service_name' => $this->request->getPost('service_name'),
            'icon'         => $this->request->getPost('icon') ?? 'check',
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'digisaathi-services', $id);
        return redirect()->to('/admin/digisaathi-services')->with('message', 'Service updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'digisaathi-services', $id);
        return redirect()->to('/admin/digisaathi-services')->with('message', 'Service deleted.');
    }
}