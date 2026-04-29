<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrivacyPolicySectionModel;

class PrivacyPolicySections extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PrivacyPolicySectionModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/privacy_policy_sections/index', $data);
    }

    public function create()
    {
        return view('admin/privacy_policy_sections/form');
    }

    public function store()
    {
        $rules = [
            'title'      => 'required|max_length[255]',
            'content'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'privacy-policy-sections', $id);
        return redirect()->to('/admin/privacy-policy-sections')->with('message', 'Privacy section added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/privacy-policy-sections')->with('error', 'Not found.');
        return view('admin/privacy_policy_sections/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'title'      => 'required|max_length[255]',
            'content'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'title'      => $this->request->getPost('title'),
            'content'    => $this->request->getPost('content'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'privacy-policy-sections', $id);
        return redirect()->to('/admin/privacy-policy-sections')->with('message', 'Privacy section updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'privacy-policy-sections', $id);
        return redirect()->to('/admin/privacy-policy-sections')->with('message', 'Privacy section deleted.');
    }
}