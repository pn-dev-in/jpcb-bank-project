<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuickActionModel;

class QuickActions extends BaseController
{
    protected $quickActionModel;

    public function __construct()
    {
        $this->quickActionModel = new QuickActionModel();
    }

    // List all quick actions
    public function index()
    {
        $quickActions = $this->quickActionModel->orderBy('id', 'ASC')->findAll();
        return view('admin/quick_actions/index', ['quickActions' => $quickActions]);
    }

    // Show create form
    public function create()
    {
        return view('admin/quick_actions/form');
    }

    // Store new quick action
    public function store()
    {
        $rules = [
            'title'       => 'required|max_length[100]',
            'description' => 'permit_empty|max_length[150]',
            'icon'        => 'required|max_length[100]',
            'link'        => 'required|max_length[255]',
            'is_alert'    => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->quickActionModel->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'link'        => $this->request->getPost('link'),
            'is_alert'    => $this->request->getPost('is_alert') ?? 0,
        ]);

        return redirect()->to('/admin/quick-actions')->with('message', 'Quick action added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $quickAction = $this->quickActionModel->find($id);
        if (!$quickAction) {
            return redirect()->to('/admin/quick-actions')->with('error', 'Quick action not found.');
        }
        return view('admin/quick_actions/form', ['quickAction' => $quickAction]);
    }

    // Update quick action
    public function update($id)
    {
        $rules = [
            'title'       => 'required|max_length[100]',
            'description' => 'permit_empty|max_length[150]',
            'icon'        => 'required|max_length[100]',
            'link'        => 'required|max_length[255]',
            'is_alert'    => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->quickActionModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'link'        => $this->request->getPost('link'),
            'is_alert'    => $this->request->getPost('is_alert') ?? 0,
        ]);

        return redirect()->to('/admin/quick-actions')->with('message', 'Quick action updated successfully.');
    }

    // Delete quick action
    public function delete($id)
    {
        $this->quickActionModel->delete($id);
        return redirect()->to('/admin/quick-actions')->with('message', 'Quick action deleted.');
    }
}