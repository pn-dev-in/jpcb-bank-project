<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AtmDoModel;

class AtmDos extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AtmDoModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/atm_dos/index', $data);
    }

    public function create()
    {
        return view('admin/atm_dos/form');
    }

    public function store()
    {
        $rules = [
            'item'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'item'       => $this->request->getPost('item'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        if ($id) {
            log_activity('Created', 'atm_dos', $id);
            return redirect()->to('/admin/atm-dos')->with('success', 'Do\'s item added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/atm-dos')->with('error', 'Not found.');
        return view('admin/atm_dos/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'item'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updated = $this->model->update($id, [
            'item'       => $this->request->getPost('item'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        if ($updated) {
            log_activity('Updated', 'atm_dos', $id);
            return redirect()->to('/admin/atm-dos')->with('success', 'Do\'s item updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update.');
        }
    }

    public function delete($id)
    {
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'atm_dos', $id);
            return redirect()->to('/admin/atm-dos')->with('success', 'Do\'s item deleted.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete.');
        }
    }
}