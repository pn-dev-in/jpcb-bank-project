<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingsModel;

class Settings extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SettingsModel();
    }

    public function edit()
    {
        $settings = $this->model->find(1);
        if (!$settings) {
            // Insert default settings if missing
            $this->model->insert([
                'site_name' => 'JPCB',
                'phone' => '0257-2220055',
                'email' => 'info@jpcb.in',
                'address' => 'Near Railway Station, Jalgaon - 425001, Maharashtra',
                'business_hours' => 'Mon-Sat: 10:00 AM - 4:00 PM',
                'digital_banking_link' => 'digital/mobile-banking',
                'locate_branch_link' => 'about/branches',
                'block_card_link' => 'digital/block-card',
                'lodge_complaint_link' => 'complaints',
                'digital_banking_button_text' => 'Digital Banking',
                'footer_address' => 'Near Railway Station,<br>Jalgaon - 425001, Maharashtra',
                'copyright_text' => '© The Jalgaon Peoples Co-Op. Bank Ltd. All rights reserved.',
                'rbi_guidelines_text' => 'RBI Guidelines',
                'rbi_guidelines_link' => 'https://rbi.org.in',
                'bank_type_text' => 'Multi-State Scheduled Co-operative Bank',
                'phone_alternate' => $this->request->getPost('phone_alternate'),
    'toll_free'       => $this->request->getPost('toll_free'),
    'helpline'        => $this->request->getPost('helpline'),
    'email_support'   => $this->request->getPost('email_support'),
            ]);
            $settings = $this->model->find(1);
        }
        return view('admin/settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $rules = [
            // General
            'site_name' => 'required|max_length[150]',
            'phone' => 'required|max_length[20]',
            'email' => 'required|valid_email|max_length[150]',
            'address' => 'permit_empty',
            'business_hours' => 'required|max_length[255]',
            // Header buttons
            'digital_banking_link' => 'required|max_length[255]',
            'locate_branch_link' => 'required|max_length[255]',
            'block_card_link' => 'required|max_length[255]',
            'lodge_complaint_link' => 'required|max_length[255]',
            'digital_banking_button_text' => 'required|max_length[100]',
            // Footer fields (optional)
            'footer_address' => 'permit_empty',
            'copyright_text' => 'permit_empty|max_length[255]',
            'rbi_guidelines_text' => 'permit_empty|max_length[255]',
            'rbi_guidelines_link' => 'permit_empty|max_length[255]',
            'bank_type_text' => 'permit_empty|max_length[255]',
            'facebook_url' => 'permit_empty|valid_url|max_length[255]',
            'twitter_url' => 'permit_empty|valid_url|max_length[255]',
            'linkedin_url' => 'permit_empty|valid_url|max_length[255]',
            'youtube_url' => 'permit_empty|valid_url|max_length[255]',
            'phone_alternate' => 'permit_empty|max_length[50]',
'toll_free'       => 'permit_empty|max_length[50]',
'helpline'        => 'permit_empty|max_length[50]',
'email_support'   => 'permit_empty|valid_email|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update(1, [
            // General
            'site_name' => $this->request->getPost('site_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
            'business_hours' => $this->request->getPost('business_hours'),
            // Header
            'digital_banking_link' => $this->request->getPost('digital_banking_link'),
            'locate_branch_link' => $this->request->getPost('locate_branch_link'),
            'block_card_link' => $this->request->getPost('block_card_link'),
            'lodge_complaint_link' => $this->request->getPost('lodge_complaint_link'),
            'digital_banking_button_text' => $this->request->getPost('digital_banking_button_text'),
            // Footer
            'footer_address' => $this->request->getPost('footer_address'),
            'copyright_text' => $this->request->getPost('copyright_text'),
            'rbi_guidelines_text' => $this->request->getPost('rbi_guidelines_text'),
            'rbi_guidelines_link' => $this->request->getPost('rbi_guidelines_link'),
            'bank_type_text' => $this->request->getPost('bank_type_text'),
            'facebook_url' => $this->request->getPost('facebook_url'),
            'twitter_url' => $this->request->getPost('twitter_url'),
            'linkedin_url' => $this->request->getPost('linkedin_url'),
            'youtube_url' => $this->request->getPost('youtube_url'),
        ]);
        log_activity('Updated', 'settings', 1);
        return redirect()->to('/admin/settings/edit')->with('message', 'Settings updated successfully.');
    }
}