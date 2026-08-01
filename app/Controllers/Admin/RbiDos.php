<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiDoModel;

class RbiDos extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiDoModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/rbi_dos/index', $data);
    }

    public function create()
    {
        return view('admin/rbi_dos/form');
    }

    public function store()
    {
        $rules = [
            'item'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'item'       => $this->request->getPost('item'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'rbi-dos', $id);
        return redirect()->to('/admin/rbi-dos')->with('message', 'Do item added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/rbi-dos')->with('error', 'Not found.');
        return view('admin/rbi_dos/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'item'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'item'       => $this->request->getPost('item'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'rbi-dos', $id);
        return redirect()->to('/admin/rbi-dos')->with('message', 'Do item updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'rbi-dos', $id);
        return redirect()->to('/admin/rbi-dos')->with('message', 'Do item deleted.');
    }
}