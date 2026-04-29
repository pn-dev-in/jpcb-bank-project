<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TrustBadgeModel;

class TrustBadges extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TrustBadgeModel();
    }

    public function index()
    {
        $badges = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/trust_badges/index', ['badges' => $badges]);
    }

    public function create()
    {
        return view('admin/trust_badges/form');
    }

    public function store()
    {
        $rules = [
            'icon' => 'required|max_length[50]',
            'label' => 'required|max_length[100]',
            'color_class' => 'permit_empty|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'icon' => $this->request->getPost('icon'),
            'label' => $this->request->getPost('label'),
            'color_class' => $this->request->getPost('color_class'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created','trust-badges', $id);
        return redirect()->to('/admin/trust-badges')->with('message', 'Badge added.');
    }

    public function edit($id)
    {
        $badge = $this->model->find($id);
        if (!$badge) {
            return redirect()->to('/admin/trust-badges')->with('error', 'Badge not found.');
        }
        return view('admin/trust_badges/form', ['badge' => $badge]);
    }

    public function update($id)
    {
        $rules = [
            'icon' => 'required|max_length[50]',
            'label' => 'required|max_length[100]',
            'color_class' => 'permit_empty|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'icon' => $this->request->getPost('icon'),
            'label' => $this->request->getPost('label'),
            'color_class' => $this->request->getPost('color_class'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);
        log_activity('Updated','trust-badges', $id);
        return redirect()->to('/admin/trust-badges')->with('message', 'Badge updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted','trust-badges', $id);
        return redirect()->to('/admin/trust-badges')->with('message', 'Badge deleted.');
    }
}