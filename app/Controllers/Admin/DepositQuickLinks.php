<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepositQuickLinkModel;

class DepositQuickLinks extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DepositQuickLinkModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/deposit_quick_links/index', $data);
    }

    public function create()
    {
        return view('admin/deposit_quick_links/form');
    }

    public function store()
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'label'      => 'required|max_length[100]',
            'href'       => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'icon'       => $this->request->getPost('icon'),
            'label'      => $this->request->getPost('label'),
            'href'       => $this->request->getPost('href'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'deposit-quick-links', $id);
        return redirect()->to('/admin/deposit-quick-links')->with('message', 'Quick link added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/deposit-quick-links')->with('error', 'Not found.');
        return view('admin/deposit_quick_links/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'label'      => 'required|max_length[100]',
            'href'       => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'icon'       => $this->request->getPost('icon'),
            'label'      => $this->request->getPost('label'),
            'href'       => $this->request->getPost('href'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'deposit-quick-links', $id);
        return redirect()->to('/admin/deposit-quick-links')->with('message', 'Quick link updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'deposit-quick-links', $id);
        return redirect()->to('/admin/deposit-quick-links')->with('message', 'Quick link deleted.');
    }
}