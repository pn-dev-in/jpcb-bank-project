<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TrustSectionSettingsModel;

class TrustSection extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TrustSectionSettingsModel();
    }

    public function edit()
    {
        $data = $this->model->find(1);
        if (!$data) {
            $this->model->insert(['heading' => 'Why Choose Us', 'subheading' => 'Trusted by generations...']);
            $data = $this->model->find(1);
        }
        return view('admin/trust_section/edit', ['settings' => $data]);
    }

    public function update()
    {
        $rules = ['heading' => 'required', 'subheading' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->model->update(1, [
            'heading' => $this->request->getPost('heading'),
            'subheading' => $this->request->getPost('subheading')
        ]);
        return redirect()->to('/admin/trust-section/edit')->with('message', 'Updated.');
    }
}