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
        $keys = ['rtgs_description', 'neft_description', 'rtgs_features', 'neft_features', 'rtgs_neft_steps'];
        $settings = [];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }
        return view('admin/digital_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $keys = ['rtgs_description', 'neft_description', 'rtgs_features', 'neft_features', 'rtgs_neft_steps'];
        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $existing = $this->model->where('key', $key)->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $value]);
            } else {
                $this->model->insert(['key' => $key, 'value' => $value]);
            }
        }
        $id = $this->model->getInsertID();
        log_activity('Updated', 'digital-settings', 1);
        return redirect()->to('/admin/digital-settings/edit')->with('message', 'Digital settings updated.');
    }
}