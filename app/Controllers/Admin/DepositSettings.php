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
        $keys = ['dicgc_intro', 'deaf_intro', 'interest_rate_notes', 'savings_documents'];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }
        return view('admin/deposit_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $keys = ['dicgc_intro', 'deaf_intro', 'interest_rate_notes', 'savings_documents'];
        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $existing = $this->model->where('key', $key)->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $value]);
            } else {
                $this->model->insert(['key' => $key, 'value' => $value]);
            }
        }
        return redirect()->to('/admin/deposit-settings/edit')->with('message', 'Deposit settings updated.');
    }
}