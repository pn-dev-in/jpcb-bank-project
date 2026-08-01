<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AboutValueModel;

class AboutValues extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AboutValueModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/about_values/index', $data);
    }

    public function create()
    {
        return view('admin/about_values/form');
    }

    public function store()
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'icon'       => $this->request->getPost('icon'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'about_values', $id);
        return redirect()->to('/admin/about-values')->with('message', 'Value added successfully.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/about-values')->with('error', 'Item not found.');
        }
        return view('admin/about_values/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'icon'       => $this->request->getPost('icon'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'about_values', $id);
        return redirect()->to('/admin/about-values')->with('message', 'Value updated successfully.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'about_values', $id);
        return redirect()->to('/admin/about-values')->with('message', 'Value deleted.');
    }
}