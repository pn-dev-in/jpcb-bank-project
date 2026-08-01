<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiSettingModel;

class RbiSettings extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiSettingModel();
    }

    public function edit()
    {
        $keys = ['ombudsman_intro', 'booklet_intro', 'integrated_ombudsman_intro', 'booklet_pdf', 'integrated_ombudsman_banner', 'fair_practice_pdf', 'ombudsman_pdf',];
        $settings = [];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }
        return view('admin/rbi_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $keys = ['ombudsman_intro', 'booklet_intro', 'integrated_ombudsman_intro',];

        // Handle PDF upload
        $file = $this->request->getFile('booklet_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/rbi/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $pdfPath = 'uploads/rbi/' . $newName;

            // Delete old file if it exists and is not the default
            $oldPath = $this->model->where('key', 'booklet_pdf')->first()['value'] ?? '';
            if ($oldPath && file_exists(FCPATH . $oldPath)) {
                @unlink(FCPATH . $oldPath);
            }

            // Update the key
            $this->model->where('key', 'booklet_pdf')->set('value', $pdfPath)->update();
        }

        $fairPracticeFile = $this->request->getFile('fair_practice_pdf');

        if ($fairPracticeFile && $fairPracticeFile->isValid() && !$fairPracticeFile->hasMoved()) {

            $uploadDir = FCPATH . 'uploads/rbi/';

            if (!is_dir($uploadDir)) {

                mkdir($uploadDir, 0755, true);
            }

            $newName = $fairPracticeFile->getRandomName();

            $fairPracticeFile->move($uploadDir, $newName);

            $pdfPath = 'uploads/rbi/' . $newName;

            // Delete old PDF
            $oldPath = $this->model
                ->where('key', 'fair_practice_pdf')
                ->first()['value'] ?? '';

            if ($oldPath && file_exists(FCPATH . $oldPath)) {

                @unlink(FCPATH . $oldPath);
            }

            // Update DB
            $existing = $this->model
                ->where('key', 'fair_practice_pdf')
                ->first();

            if ($existing) {

                $this->model
                    ->update($existing['id'], [
                        'value' => $pdfPath
                    ]);

            } else {

                $this->model->insert([
                    'key' => 'fair_practice_pdf',
                    'value' => $pdfPath
                ]);
            }
        }

        $ombudsmanFile = $this->request->getFile('ombudsman_pdf');

        if ($ombudsmanFile && $ombudsmanFile->isValid() && !$ombudsmanFile->hasMoved()) {

            $uploadDir = FCPATH . 'uploads/rbi/';

            if (!is_dir($uploadDir)) {

                mkdir($uploadDir, 0755, true);
            }

            $newName = $ombudsmanFile->getRandomName();

            $ombudsmanFile->move($uploadDir, $newName);

            $pdfPath = 'uploads/rbi/' . $newName;

            // Delete old PDF
            $oldPath = $this->model
                ->where('key', 'ombudsman_pdf')
                ->first()['value'] ?? '';

            if ($oldPath && file_exists(FCPATH . $oldPath)) {

                @unlink(FCPATH . $oldPath);
            }

            // Update DB
            $existing = $this->model
                ->where('key', 'ombudsman_pdf')
                ->first();

            if ($existing) {

                $this->model
                    ->update($existing['id'], [
                        'value' => $pdfPath
                    ]);

            } else {

                $this->model->insert([
                    'key' => 'ombudsman_pdf',
                    'value' => $pdfPath
                ]);
            }
        }
        $image = $this->request->getFile('integrated_ombudsman_banner');

        if ($image && $image->isValid() && !$image->hasMoved()) {

            $uploadDir = FCPATH . 'uploads/rbi/';

            if (!is_dir($uploadDir)) {

                mkdir($uploadDir, 0755, true);
            }

            $newName = $image->getRandomName();

            $image->move($uploadDir, $newName);

            $imagePath = 'uploads/rbi/' . $newName;

            // Delete old image
            $oldImage = $this->model
                ->where('key', 'integrated_ombudsman_banner')
                ->first()['value'] ?? '';

            if ($oldImage && file_exists(FCPATH . $oldImage)) {

                @unlink(FCPATH . $oldImage);
            }

            // Update DB
            $existing = $this->model
                ->where('key', 'integrated_ombudsman_banner')
                ->first();

            if ($existing) {

                $this->model
                    ->update($existing['id'], [
                        'value' => $imagePath
                    ]);

            } else {

                $this->model->insert([
                    'key' => 'integrated_ombudsman_banner',
                    'value' => $imagePath
                ]);
            }
        }
        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $existing = $this->model->where('key', $key)->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $value]);
            } else {
                $this->model->insert(['key' => $key, 'value' => $value]);
            }
        }
        log_activity('Updated', 'rbi-settings', 1);
        return redirect()->to('/admin/rbi-settings/edit')->with('success', 'RBI settings updated.');
    }
}