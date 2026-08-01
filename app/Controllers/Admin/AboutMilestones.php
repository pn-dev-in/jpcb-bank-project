<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AboutMilestoneModel;

class AboutMilestones extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AboutMilestoneModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/about_milestones/index', $data);
    }

    public function create()
    {
        return view('admin/about_milestones/form');
    }

    public function store()
    {
        $rules = [
            'year'       => 'required|max_length[10]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'year'       => $this->request->getPost('year'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'about_milestones', $id);
        return redirect()->to('/admin/about-milestones')->with('message', 'Milestone added successfully.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/about-milestones')->with('error', 'Item not found.');
        }
        return view('admin/about_milestones/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'year'       => 'required|max_length[10]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'year'       => $this->request->getPost('year'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'about_milestones', $id);
        return redirect()->to('/admin/about-milestones')->with('message', 'Milestone updated successfully.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'about_milestones', $id);
        return redirect()->to('/admin/about-milestones')->with('message', 'Milestone deleted.');
    }
}