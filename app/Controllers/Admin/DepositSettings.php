<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepositSettingModel;

class DepositSettings extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DepositSettingModel();
    }

    public function edit()
    {
        $settings = [];
        $keys = [
            'dicgc_intro', 'deaf_intro', 'interest_rate_notes',
            'savings_documents', 'dicgc_banner', 'dicgc_banner_text',
            'deposit_rates_pdf', 'deaf_claim_form_pdf',
        ];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }
        return view('admin/deposit_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        // ---------- 1. Handle PDF upload (deposit interest rate schedule) ----------
        $pdfFile = $this->request->getFile('deposit_rates_pdf');
        if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/deposits/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $pdfFile->getRandomName();
            $pdfFile->move($uploadDir, $newName);
            $pdfPath = 'uploads/deposits/' . $newName;

            // Delete old PDF
            $oldPdf = $this->model->where('key', 'deposit_rates_pdf')->first()['value'] ?? '';
            if ($oldPdf && file_exists(FCPATH . $oldPdf)) {
                @unlink(FCPATH . $oldPdf);
            }

            $this->model->where('key', 'deposit_rates_pdf')->set('value', $pdfPath)->update();
        }

        // ---------- 2. Handle DICGC banner image upload ----------
        $bannerFile = $this->request->getFile('dicgc_banner');
        if ($bannerFile && $bannerFile->isValid() && !$bannerFile->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/deposits/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $bannerFile->getRandomName();
            $bannerFile->move($uploadDir, $newName);
            $imagePath = 'uploads/deposits/' . $newName;

            // Delete old banner
            $oldBanner = $this->model->where('key', 'dicgc_banner')->first()['value'] ?? '';
            if ($oldBanner && file_exists(FCPATH . $oldBanner)) {
                @unlink(FCPATH . $oldBanner);
            }

            $existing = $this->model->where('key', 'dicgc_banner')->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $imagePath]);
            } else {
                $this->model->insert(['key' => 'dicgc_banner', 'value' => $imagePath]);
            }
        }

        // ---------- NEW: Handle DEAF claim form PDF upload ----------
$deafPdfFile = $this->request->getFile('deaf_claim_form_pdf');
if ($deafPdfFile && $deafPdfFile->isValid() && !$deafPdfFile->hasMoved()) {
    $uploadDir = FCPATH . 'uploads/deposits/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $newName = $deafPdfFile->getRandomName();
    $deafPdfFile->move($uploadDir, $newName);
    $pdfPath = 'uploads/deposits/' . $newName;

    // Delete old file
    $oldPdf = $this->model->where('key', 'deaf_claim_form_pdf')->first()['value'] ?? '';
    if ($oldPdf && file_exists(FCPATH . $oldPdf)) {
        @unlink(FCPATH . $oldPdf);
    }

    $this->model->where('key', 'deaf_claim_form_pdf')->set('value', $pdfPath)->update();
}

        // ---------- 3. Save all text-based keys (exclude file keys) ----------
        $textKeys = [
            'dicgc_intro', 'deaf_intro', 'interest_rate_notes',
            'savings_documents', 'dicgc_banner_text'
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

        log_activity('Updated', 'deposit-settings', 0);
        return redirect()->to('/admin/deposit-settings/edit')->with('message', 'Deposit settings updated.');
    }
}