<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AboutStatModel;

class AboutStats extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AboutStatModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/about_stats/index', $data);
    }

    public function create()
    {
        return view('admin/about_stats/form');
    }

    public function store()
    {
        $rules = [
            'number'      => 'required|max_length[50]',
            'label'       => 'required|max_length[100]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'number'      => $this->request->getPost('number'),
            'label'       => $this->request->getPost('label'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'about_stats', $id);
        return redirect()->to('/admin/about-stats')->with('message', 'Item added successfully.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/about-stats')->with('error', 'Item not found.');
        }
        return view('admin/about_stats/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'number'      => 'required|max_length[50]',
            'label'       => 'required|max_length[100]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'number'      => $this->request->getPost('number'),
            'label'       => $this->request->getPost('label'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'about_stats', $id);
        return redirect()->to('/admin/about-stats')->with('message', 'Item updated successfully.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'about_stats', $id);
        return redirect()->to('/admin/about-stats')->with('message', 'Item deleted.');
    }
}