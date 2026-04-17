<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GrievanceSectionSettingsModel;

class GrievanceSection extends BaseController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new GrievanceSectionSettingsModel();
    }

    public function edit()
    {
        $settings = $this->settingsModel->find(1);
        if (!$settings) {
            $this->settingsModel->insert([
                'heading' => 'Grievance Redressal',
                'subheading' => 'We are committed to resolving your complaints fairly and promptly. Follow the RBI-aligned escalation process below.'
            ]);
            $settings = $this->settingsModel->find(1);
        }
        return view('admin/grievance_section/edit', ['settings' => $settings]);
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

        return redirect()->to('/admin/grievance-section/edit')->with('message', 'Grievance section updated successfully.');
    }
}