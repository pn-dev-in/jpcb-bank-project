<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DicgcFaqModel;

class DicgcFaqs extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DicgcFaqModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/dicgc_faqs/index', $data);
    }

    public function create()
    {
        return view('admin/dicgc_faqs/form');
    }

    public function store()
    {
        $rules = [
            'question'   => 'required',
            'answer'     => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'question'   => $this->request->getPost('question'),
            'answer'     => $this->request->getPost('answer'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'dicgc-faqs', $id);
        return redirect()->to('/admin/dicgc-faqs')->with('message', 'FAQ added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/dicgc-faqs')->with('error', 'Not found.');
        return view('admin/dicgc_faqs/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'question'   => 'required',
            'answer'     => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'question'   => $this->request->getPost('question'),
            'answer'     => $this->request->getPost('answer'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'dicgc-faqs', $id);
        return redirect()->to('/admin/dicgc-faqs')->with('message', 'FAQ updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'dicgc-faqs', $id);
        return redirect()->to('/admin/dicgc-faqs')->with('message', 'FAQ deleted.');
    }
}