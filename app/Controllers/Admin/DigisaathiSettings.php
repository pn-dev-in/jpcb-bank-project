<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigisaathiSettingModel;

class DigisaathiSettings extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigisaathiSettingModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('key', 'asc')->findAll();
        return view('admin/digisaathi_settings/index', $data);
    }

    public function create()
    {
        return view('admin/digisaathi_settings/form');
    }

    public function store()
    {
        $rules = [
            'key'   => 'required|max_length[100]|is_unique[digisaathi_settings.key]',
            'value' => 'permit_empty',
            'type'  => 'required|in_list[text,textarea,image,json]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'key'   => $this->request->getPost('key'),
            'value' => $this->request->getPost('value'),
            'type'  => $this->request->getPost('type'),
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'digisaathi-settings', $id);
        return redirect()->to('/admin/digisaathi-settings')->with('message', 'Setting added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/digisaathi-settings')->with('error', 'Not found.');
        return view('admin/digisaathi_settings/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'key'   => "required|max_length[100]|is_unique[digisaathi_settings.key,id,$id]",
            'value' => 'permit_empty',
            'type'  => 'required|in_list[text,textarea,image,json]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'key'   => $this->request->getPost('key'),
            'value' => $this->request->getPost('value'),
            'type'  => $this->request->getPost('type'),
        ]);
        log_activity('Updated', 'digisaathi-settings', $id);
        return redirect()->to('/admin/digisaathi-settings')->with('message', 'Setting updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'digisaathi-settings', $id);
        return redirect()->to('/admin/digisaathi-settings')->with('message', 'Setting deleted.');
    }
}