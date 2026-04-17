<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SafetySectionSettingsModel;

class SafetySection extends BaseController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new SafetySectionSettingsModel();
    }

    public function index()
    {
        return redirect()->to('/admin/safety-section/edit');
    }   

    public function edit()
    {
        $settings = $this->settingsModel->find(1);
        if (!$settings) {
            // fallback insert (same as default)
            $this->settingsModel->insert([
                'heading' => 'Stay Safe from Fraud',
                'warning_text' => '⚠️ We NEVER ask for OTP, PIN, or Password over call, SMS, or email.',
                'description' => 'Beware of phishing websites...',
                'button1_text' => 'Safety Tips',
                'button1_link' => 'rbi/dos-and-donts',
                'button2_text' => 'Report Fraud: 0257-2220055',
                'button2_link' => 'tel:02572220055',
                'button3_text' => 'Report Online',
                'button3_link' => 'https://cybercrime.gov.in'
            ]);
            $settings = $this->settingsModel->find(1);
        }
        return view('admin/safety_section/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $rules = [
            'heading'        => 'required|max_length[255]',
            'warning_text'   => 'required',
            'description'    => 'required',
            'button1_text'   => 'required|max_length[100]',
            'button1_link'   => 'required|max_length[255]',
            'button2_text'   => 'required|max_length[100]',
            'button2_link'   => 'required|max_length[255]',
            'button3_text'   => 'required|max_length[100]',
            'button3_link'   => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->settingsModel->update(1, [
            'heading'        => $this->request->getPost('heading'),
            'warning_text'   => $this->request->getPost('warning_text'),
            'description'    => $this->request->getPost('description'),
            'button1_text'   => $this->request->getPost('button1_text'),
            'button1_link'   => $this->request->getPost('button1_link'),
            'button2_text'   => $this->request->getPost('button2_text'),
            'button2_link'   => $this->request->getPost('button2_link'),
            'button3_text'   => $this->request->getPost('button3_text'),
            'button3_link'   => $this->request->getPost('button3_link'),
        ]);

        return redirect()->to('/admin/safety-section/edit')->with('message', 'Safety section updated successfully.');
    }

}