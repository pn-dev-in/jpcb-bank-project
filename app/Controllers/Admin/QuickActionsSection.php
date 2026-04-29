<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuickActionsSectionSettingsModel;

class QuickActionsSection extends BaseController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new QuickActionsSectionSettingsModel();
    }

    public function edit()
    {
        $settings = $this->settingsModel->find(1);
        if (!$settings) {
            $this->settingsModel->insert(['heading' => 'Quick Actions', 'subheading' => 'Frequently used banking services at your fingertips']);
            $settings = $this->settingsModel->find(1);
        }
        return view('admin/quick_actions_section/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $rules = [
            'heading'    => 'required|max_length[255]',
            'subheading' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->settingsModel->update(1, [
            'heading'    => $this->request->getPost('heading'),
            'subheading' => $this->request->getPost('subheading'),
        ]);
        log_activity('Updated', 'quick-actions-section', 1);
        return redirect()->to('/admin/quick-actions-section/edit')->with('message', 'Quick Actions section updated.');
    }
}