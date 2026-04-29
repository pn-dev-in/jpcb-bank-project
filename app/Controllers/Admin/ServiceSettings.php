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
        $keys = ['locker_eligibility_list', 'positive_pay_fields', 'positive_pay_submission_methods', 'positive_pay_important_note'];
        $settings = [];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }
        return view('admin/service_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $keys = ['locker_eligibility_list', 'positive_pay_fields', 'positive_pay_submission_methods', 'positive_pay_important_note'];
        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $existing = $this->model->where('key', $key)->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $value]);
            } else {
                $this->model->insert(['key' => $key, 'value' => $value]);
            }
        }
        log_activity('Updated', 'service-settings', 1);
        return redirect()->to('/admin/service-settings/edit')->with('message', 'Service settings updated.');
    }
}