<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AtmGuidelineModel;

class AtmGuidelines extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AtmGuidelineModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/atm_guidelines/index', $data);
    }

    public function create()
    {
        return view('admin/atm_guidelines/form');
    }

    public function store()
    {
        $rules = [
            'guideline'  => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'guideline'  => $this->request->getPost('guideline'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        if ($id) {
            log_activity('Created', 'atm_guidelines', $id);
            return redirect()->to('/admin/atm-guidelines')->with('success', 'Guideline added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/atm-guidelines')->with('error', 'Not found.');
        return view('admin/atm_guidelines/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'guideline'  => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updated = $this->model->update($id, [
            'guideline'  => $this->request->getPost('guideline'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        if ($updated) {
            log_activity('Updated', 'atm_guidelines', $id);
            return redirect()->to('/admin/atm-guidelines')->with('success', 'Guideline updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update.');
        }
    }

    public function delete($id)
    {
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'atm_guidelines', $id);
            return redirect()->to('/admin/atm-guidelines')->with('success', 'Guideline deleted.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete.');
        }
    }
}