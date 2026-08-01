<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceSettingModel;

class ServiceSettings extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ServiceSettingModel();
    }

    public function edit()
    {
        $keys = [
            'locker_eligibility_list',
            'positive_pay_fields',
            'positive_pay_submission_methods',
            'positive_pay_important_note',
            'positive_pay_banner_html',
            'positive_pay_how_it_works',
            'positive_pay_sample_image',
            'positive_pay_sample_note',
            'positive_pay_footer_note',
            'insurance_intro',
            'general_insurance_note',
            'health_insurance_intro',
            'pmjjby_note',
            'pmsby_note',
            'tieup_partners_note',
            'charges_effective_date',
            'charges_advances_penal_note',
            'charges_cash_note',
            // NEW: service charges PDF
            'service_charges_pdf',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }

        return view('admin/service_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        // ---- Handle Positive Pay sample image upload ----
        $imagePath = $this->model->where('key', 'positive_pay_sample_image')->first()['value'] ?? '';
        $file = $this->request->getFile('positive_pay_sample_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'public/uploads/positive_pay/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $imagePath = 'uploads/positive_pay/' . $newName;

            $oldPath = $this->model->where('key', 'positive_pay_sample_image')->first()['value'] ?? '';
            if ($oldPath && $oldPath !== 'assets/img/pps-sample-cheque.png' && file_exists(FCPATH . 'public/' . $oldPath)) {
                @unlink(FCPATH . 'public/' . $oldPath);
            }

            $existingImage = $this->model->where('key', 'positive_pay_sample_image')->first();
            if ($existingImage) {
                $this->model->update($existingImage['id'], ['value' => $imagePath]);
            } else {
                $this->model->insert(['key' => 'positive_pay_sample_image', 'value' => $imagePath]);
            }
        }

        // ---- NEW: Handle Service Charges PDF upload ----
        $chargesPdf = $this->model->where('key', 'service_charges_pdf')->first()['value'] ?? '';
        $file = $this->request->getFile('service_charges_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/forms/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $chargesPdf = 'uploads/forms/' . $newName;

            // Delete old file
            $oldPdf = $this->model->where('key', 'service_charges_pdf')->first()['value'] ?? '';
            if ($oldPdf && file_exists(FCPATH . $oldPdf)) {
                @unlink(FCPATH . $oldPdf);
            }

            $existingPdf = $this->model->where('key', 'service_charges_pdf')->first();
            if ($existingPdf) {
                $this->model->update($existingPdf['id'], ['value' => $chargesPdf]);
            } else {
                $this->model->insert(['key' => 'service_charges_pdf', 'value' => $chargesPdf]);
            }
        }

        // ---- Save all text‑based keys (exclude file keys) ----
        $textKeys = [
            'locker_eligibility_list',
            'positive_pay_fields',
            'positive_pay_submission_methods',
            'positive_pay_important_note',
            'positive_pay_banner_html',
            'positive_pay_how_it_works',
            'positive_pay_sample_note',
            'positive_pay_footer_note',
            'insurance_intro',
            'general_insurance_note',
            'health_insurance_intro',
            'pmjjby_note',
            'pmsby_note',
            'tieup_partners_note',
            'charges_effective_date',
            'charges_advances_penal_note',
            'charges_cash_note',
        ];

        foreach ($textKeys as $key) {
            $value = $this->request->getPost($key) ?? '';
            $existing = $this->model->where('key', $key)->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $value]);
            } else {
                $this->model->insert(['key' => $key, 'value' => $value]);
            }
        }

        log_activity('Updated', 'service-settings', 1);
        return redirect()->to('/admin/service-settings/edit')->with('success', 'Service settings updated.');
    }
}