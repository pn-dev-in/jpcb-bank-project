<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AccessibilityFeatureModel;

class AccessibilityFeatures extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AccessibilityFeatureModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/accessibility_features/index', $data);
    }

    public function create()
    {
        return view('admin/accessibility_features/form');
    }

    public function store()
    {
        $rules = [
            'feature'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'feature'    => $this->request->getPost('feature'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'accessibility_features', $id);
        return redirect()->to('/admin/accessibility-features')->with('message', 'Accessibility feature added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/accessibility-features')->with('error', 'Not found.');
        return view('admin/accessibility_features/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'feature'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'feature'    => $this->request->getPost('feature'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'accessibility_features', $id);
        return redirect()->to('/admin/accessibility-features')->with('message', 'Accessibility feature updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'accessibility_features', $id);
        return redirect()->to('/admin/accessibility-features')->with('message', 'Accessibility feature deleted.');
    }
}