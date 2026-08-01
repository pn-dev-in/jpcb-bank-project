<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LockerSizeModel;

class LockerSizes extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LockerSizeModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/locker_sizes/index', $data);
    }

    public function create()
    {
        return view('admin/locker_sizes/form');
    }

    public function store()
    {
        $rules = [
            'size'       => 'required|max_length[50]',
            'dimensions' => 'required|max_length[100]',
            'rent'       => 'required|max_length[50]',
            'deposit'    => 'required|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'size'       => $this->request->getPost('size'),
            'dimensions' => $this->request->getPost('dimensions'),
            'rent'       => $this->request->getPost('rent'),
            'deposit'    => $this->request->getPost('deposit'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'locker-sizes', $id);
        return redirect()->to('/admin/locker-sizes')->with('message', 'Locker size added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/locker-sizes')->with('error', 'Not found.');
        return view('admin/locker_sizes/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'size'       => 'required|max_length[50]',
            'dimensions' => 'required|max_length[100]',
            'rent'       => 'required|max_length[50]',
            'deposit'    => 'required|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'size'       => $this->request->getPost('size'),
            'dimensions' => $this->request->getPost('dimensions'),
            'rent'       => $this->request->getPost('rent'),
            'deposit'    => $this->request->getPost('deposit'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'locker-sizes', $id);
        return redirect()->to('/admin/locker-sizes')->with('message', 'Locker size updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'locker-sizes', $id);
        return redirect()->to('/admin/locker-sizes')->with('message', 'Locker size deleted.');
    }
}