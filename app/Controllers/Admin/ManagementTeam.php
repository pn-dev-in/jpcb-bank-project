<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ManagementTeamModel;

class ManagementTeam extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ManagementTeamModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/management_team/index', $data);
    }

    public function create()
    {
        return view('admin/management_team/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'role'       => 'required|max_length[100]',
            'department' => 'required|max_length[100]',
            'bio'        => 'permit_empty',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'role'       => $this->request->getPost('role'),
            'department' => $this->request->getPost('department'),
            'bio'        => $this->request->getPost('bio'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/management-team')->with('message', 'Management member added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/management-team')->with('error', 'Not found.');
        return view('admin/management_team/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'role'       => 'required|max_length[100]',
            'department' => 'required|max_length[100]',
            'bio'        => 'permit_empty',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'role'       => $this->request->getPost('role'),
            'department' => $this->request->getPost('department'),
            'bio'        => $this->request->getPost('bio'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/management-team')->with('message', 'Management member updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/management-team')->with('message', 'Management member deleted.');
    }
}