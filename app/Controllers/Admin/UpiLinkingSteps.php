<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UpiLinkingStepModel;

class UpiLinkingSteps extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpiLinkingStepModel();
    }

    // List steps, optionally filtered by tab (default = null → show all)
    public function index($tab = null)
    {
        if ($tab) {
            $data['items'] = $this->model
                ->where('tab', $tab)
                ->orderBy('sort_order', 'asc')
                ->findAll();
        } else {
            $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        }

        $data['currentTab'] = $tab ?: 'all';
        $data['tabs'] = [
            'all'          => 'All Steps',
            'eligibility'  => 'Eligibility',
            'transactions' => 'Transactions',
        ];
        return view('admin/upi_linking_steps/index', $data);
    }

    public function create()
    {
        return view('admin/upi_linking_steps/form');
    }

    public function store()
    {
        $rules = [
            'tab'         => 'required|max_length[50]',
            'section'     => 'required|max_length[100]',
            'step_number' => 'required|max_length[10]',
            'title'       => 'required|max_length[100]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'tab'         => $this->request->getPost('tab'),
            'section'     => $this->request->getPost('section'),
            'step_number' => $this->request->getPost('step_number'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Created', 'upi-linking-steps', $this->model->getInsertID());
        return redirect()->to('/admin/upi-linking-steps')->with('message', 'Step added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/upi-linking-steps')->with('error', 'Not found.');
        return view('admin/upi_linking_steps/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'tab'         => 'required|max_length[50]',
            'section'     => 'required|max_length[100]',
            'step_number' => 'required|max_length[10]',
            'title'       => 'required|max_length[100]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'tab'         => $this->request->getPost('tab'),
            'section'     => $this->request->getPost('section'),
            'step_number' => $this->request->getPost('step_number'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'upi-linking-steps', $id);
        return redirect()->to('/admin/upi-linking-steps')->with('message', 'Step updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'upi-linking-steps', $id);
        return redirect()->to('/admin/upi-linking-steps')->with('message', 'Step deleted.');
    }
}