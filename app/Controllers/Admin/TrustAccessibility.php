<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TrustAccessibilityModel;

class TrustAccessibility extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TrustAccessibilityModel();
    }

    public function edit()
    {
        $data = $this->model->find(1);
        if (!$data) {
            // Insert default if missing
            $this->model->insert([
                'heading' => 'Banking for Everyone',
                'description' => 'Our website supports text resizing, high contrast, dark mode, screen readers, keyboard navigation, read-aloud, focus reading strips, and more — ensuring banking is accessible to all.',
                'button_text' => 'Accessibility Statement',
                'button_link' => 'accessibility'
            ]);
            $data = $this->model->find(1);
        }
        return view('admin/trust_accessibility/edit', ['settings' => $data]);
    }

    public function update()
    {
        $rules = [
            'heading' => 'required|max_length[255]',
            'description' => 'required',
            'button_text' => 'required|max_length[100]',
            'button_link' => 'required|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update(1, [
            'heading' => $this->request->getPost('heading'),
            'description' => $this->request->getPost('description'),
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link')
        ]);
        log_activity('Updated','trust-accessibility', 1);
        return redirect()->to('/admin/trust-accessibility/edit')->with('message', 'Accessibility section updated.');
    }
}