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
        $keys = ['ombudsman_intro', 'booklet_intro', 'integrated_ombudsman_intro'];
        $settings = [];
        foreach ($keys as $key) {
            $row = $this->model->where('key', $key)->first();
            $settings[$key] = $row['value'] ?? '';
        }
        return view('admin/rbi_settings/edit', ['settings' => $settings]);
    }

    public function update()
    {
        $keys = ['ombudsman_intro', 'booklet_intro', 'integrated_ombudsman_intro'];
        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $existing = $this->model->where('key', $key)->first();
            if ($existing) {
                $this->model->update($existing['id'], ['value' => $value]);
            } else {
                $this->model->insert(['key' => $key, 'value' => $value]);
            }
        }
        return redirect()->to('/admin/rbi-settings/edit')->with('message', 'RBI settings updated.');
    }
}