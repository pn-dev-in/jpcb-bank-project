<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigisaathiSupportFeatureModel;

class DigisaathiSupportFeatures extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigisaathiSupportFeatureModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/digisaathi_support_features/index', $data);
    }

    public function create()
    {
        return view('admin/digisaathi_support_features/form');
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|max_length[150]',
            'description' => 'permit_empty',
            'icon'        => 'permit_empty|max_length[50]',
            'link'        => 'permit_empty|max_length[255]',
            'link_text'   => 'permit_empty|max_length[100]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon') ?? 'message-square',
            'link'        => $this->request->getPost('link'),
            'link_text'   => $this->request->getPost('link_text'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'digisaathi-support-features', $id);
        return redirect()->to('/admin/digisaathi-support-features')->with('message', 'Support feature added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/digisaathi-support-features')->with('error', 'Not found.');
        return view('admin/digisaathi_support_features/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'title'       => 'required|max_length[150]',
            'description' => 'permit_empty',
            'icon'        => 'permit_empty|max_length[50]',
            'link'        => 'permit_empty|max_length[255]',
            'link_text'   => 'permit_empty|max_length[100]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon') ?? 'message-square',
            'link'        => $this->request->getPost('link'),
            'link_text'   => $this->request->getPost('link_text'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'digisaathi-support-features', $id);
        return redirect()->to('/admin/digisaathi-support-features')->with('message', 'Support feature updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'digisaathi-support-features', $id);
        return redirect()->to('/admin/digisaathi-support-features')->with('message', 'Support feature deleted.');
    }
}