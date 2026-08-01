<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigisaathiLanguageModel;

class DigisaathiLanguages extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigisaathiLanguageModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/digisaathi_languages/index', $data);
    }

    public function create()
    {
        return view('admin/digisaathi_languages/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[100]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'digisaathi-languages', $id);
        return redirect()->to('/admin/digisaathi-languages')->with('message', 'Language added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/digisaathi-languages')->with('error', 'Not found.');
        return view('admin/digisaathi_languages/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[100]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'digisaathi-languages', $id);
        return redirect()->to('/admin/digisaathi-languages')->with('message', 'Language updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'digisaathi-languages', $id);
        return redirect()->to('/admin/digisaathi-languages')->with('message', 'Language deleted.');
    }
}