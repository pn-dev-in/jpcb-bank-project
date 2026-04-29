<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TickerModel;

class TickerController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TickerModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('id', 'ASC')->findAll();
        return view('admin/ticker/index', $data);
    }

    public function create()
    {
        return view('admin/ticker/form');
    }

    public function store()
    {
        $rules = [
            'message' => 'required',
            'status'  => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'message' => $this->request->getPost('message'),
            'status'  => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created','ticker', $id);
        return redirect()->to('/admin/ticker')->with('message', 'Ticker message added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/ticker')->with('error', 'Message not found.');
        }
        return view('admin/ticker/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'message' => 'required',
            'status'  => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'message' => $this->request->getPost('message'),
            'status'  => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated','ticker', $id);
        return redirect()->to('/admin/ticker')->with('message', 'Ticker message updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted','ticker', $id);
        return redirect()->to('/admin/ticker')->with('message', 'Ticker message deleted.');
    }
}