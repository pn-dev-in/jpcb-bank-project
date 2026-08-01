<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AtmObtainStepModel;

class AtmObtainSteps extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AtmObtainStepModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/atm_obtain_steps/index', $data);
    }

    public function create()
    {
        return view('admin/atm_obtain_steps/form');
    }

    public function store()
    {
        $rules = [
            'step_number' => 'required|integer',
            'title'       => 'required|max_length[100]',
            'description' => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'step_number' => $this->request->getPost('step_number'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        if ($id) {
            log_activity('Created', 'atm_obtain_steps', $id);
            return redirect()->to('/admin/atm-obtain-steps')->with('success', 'Step added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/atm-obtain-steps')->with('error', 'Not found.');
        return view('admin/atm_obtain_steps/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'step_number' => 'required|integer',
            'title'       => 'required|max_length[100]',
            'description' => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updated = $this->model->update($id, [
            'step_number' => $this->request->getPost('step_number'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        if ($updated) {
            log_activity('Updated', 'atm_obtain_steps', $id);
            return redirect()->to('/admin/atm-obtain-steps')->with('success', 'Step updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update.');
        }
    }

    public function delete($id)
    {
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'atm_obtain_steps', $id);
            return redirect()->to('/admin/atm-obtain-steps')->with('success', 'Step deleted.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete.');
        }
    }
}