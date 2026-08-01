<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AtmServiceModel;

class AtmServices extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AtmServiceModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/atm_services/index', $data);
    }

    public function create()
    {
        return view('admin/atm_services/form');
    }

    public function store()
    {
        $rules = [
            'service_name' => 'required|max_length[100]',
            'icon'         => 'required|max_length[50]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'service_name' => $this->request->getPost('service_name'),
            'icon'         => $this->request->getPost('icon'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);
        if ($id) {
            log_activity('Created', 'atm_services', $id);
            return redirect()->to('/admin/atm-services')->with('success', 'ATM service added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/atm-services')->with('error', 'Not found.');
        return view('admin/atm_services/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'service_name' => 'required|max_length[100]',
            'icon'         => 'required|max_length[50]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updated = $this->model->update($id, [
            'service_name' => $this->request->getPost('service_name'),
            'icon'         => $this->request->getPost('icon'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);
        if ($updated) {
            log_activity('Updated', 'atm_services', $id);
            return redirect()->to('/admin/atm-services')->with('success', 'ATM service updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update.');
        }
    }

    public function delete($id)
    {
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'atm_services', $id);
            return redirect()->to('/admin/atm-services')->with('success', 'ATM service deleted.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete.');
        }
    }
}