<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigitalSettingModel;

class DigitalSettings extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigitalSettingModel();
    }

    public function edit()
    {
        $keys = [
            // Phase 1 – General Digital / Mobile Banking
            'digital_overview_intro',
            'mobile_banking_intro',
            'google_play_url',
            'app_store_url',
            'mobile_facility_text',
            // RTGS/NEFT
            'rtgs_description',
            'neft_description',
            'rtgs_features',
            'neft_features',
            'rtgs_neft_steps',
            // ATM Overview
            'atm_overview_intro',
            'atm_quick_block_text',
            'atm_quick_block_sms',
            'atm_quick_block_note',
            'atm_overview_guidelines_heading',
            // Debit Card
            'debit_card_heading',
            'debit_card_description',
            'debit_card_bullets',
            'debit_card_usage',
            'debit_card_benefits',
            // ATM Content
            'atm_green_pin_note',
            // Mobile Banking – Additional
            'jpcb_website_url',
            // Transfer Limits
            'imps_limit_per_txn',
            'imps_limit_per_day',
            'neft_limit_per_txn',
            'neft_limit_per_day',
            // Mobile Banking – Facility Tab
            'mobile_facility_heading',
            'mobile_facility_option1_title',
            'mobile_facility_option1_icon',
            'mobile_facility_option1_text',
            'mobile_facility_option2_title',
            'mobile_facility_option2_icon',
            'mobile_facility_option2_text',
            // UPI
            'upi_header_eyebrow',
            'upi_header_title',
            'upi_header_description',
            'upi_features_title',
            'upi_features_subtitle',
            'upi_features_overview_title',
            'upi_eligibility_title',
            'upi_eligibility_subtitle',
            'upi_transactions_title',
            'upi_transactions_subtitle',
            // RTGS/NEFT form PDF
            'rtgs_neft_form_pdf',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }

        return view('admin/digital_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        // ---- Handle file upload for RTGS/NEFT form PDF ----
        $file = $this->request->getFile('rtgs_neft_form_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/forms/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $pdfPath = 'uploads/forms/' . $newName;

            // Delete old file
            $oldPdf = $this->model->where('key', 'rtgs_neft_form_pdf')->first()['value'] ?? '';
            if ($oldPdf && file_exists(FCPATH . $oldPdf)) {
                @unlink(FCPATH . $oldPdf);
            }

            $existing = $this->model->where('key', 'rtgs_neft_form_pdf')->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $pdfPath]);
            } else {
                $this->model->insert(['key' => 'rtgs_neft_form_pdf', 'value' => $pdfPath]);
            }
        }

        // ---- Save all text‑based keys (exclude file keys) ----
        $textKeys = [
            'digital_overview_intro',
            'mobile_banking_intro',
            'google_play_url',
            'app_store_url',
            'mobile_facility_text',
            'rtgs_description',
            'neft_description',
            'rtgs_features',
            'neft_features',
            'rtgs_neft_steps',
            'atm_overview_intro',
            'atm_quick_block_text',
            'atm_quick_block_sms',
            'atm_quick_block_note',
            'atm_overview_guidelines_heading',
            'debit_card_heading',
            'debit_card_description',
            'debit_card_bullets',
            'debit_card_usage',
            'debit_card_benefits',
            'atm_green_pin_note',
            'jpcb_website_url',
            'imps_limit_per_txn',
            'imps_limit_per_day',
            'neft_limit_per_txn',
            'neft_limit_per_day',
            'mobile_facility_heading',
            'mobile_facility_option1_title',
            'mobile_facility_option1_icon',
            'mobile_facility_option1_text',
            'mobile_facility_option2_title',
            'mobile_facility_option2_icon',
            'mobile_facility_option2_text',
            'upi_header_eyebrow',
            'upi_header_title',
            'upi_header_description',
            'upi_features_title',
            'upi_features_subtitle',
            'upi_features_overview_title',
            'upi_eligibility_title',
            'upi_eligibility_subtitle',
            'upi_transactions_title',
            'upi_transactions_subtitle',
        ];

        foreach ($textKeys as $key) {
            $value = $this->request->getPost($key);
            $existing = $this->model->where('key', $key)->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $value]);
            } else {
                $this->model->insert(['key' => $key, 'value' => $value]);
            }
        }

        log_activity('Updated', 'digital_settings', 1);
        return redirect()->to('/admin/digital-settings/edit')->with('success', 'Digital settings updated successfully.');
    }
}