<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HomeAlertBannerModel;

class AlertBanner extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new HomeAlertBannerModel();
    }

    public function index()
    {
        if (!has_permission('alert_banners.view')) {
            return redirect()->back()->with('error', 'You do not have permission to view alert banners.');
        }

        $data['banners'] = $this->model->findAll() ?? [];
        return view('admin/alert_banner/index', $data);
    }

    public function create()
    {
        if (!has_permission('alert_banners.create')) {
            return redirect()->back()->with('error', 'You do not have permission to create alert banners.');
        }
        return view('admin/alert_banner/create');
    }

    public function store()
    {
        if (!has_permission('alert_banners.create')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $rules = [
            'status'    => 'permit_empty|integer',
            'is_popup'  => 'permit_empty|integer',
            'image'     => 'uploaded[image]|max_size[image,2048]|is_image[image]',
            'title'     => 'permit_empty|max_length[255]',
            'description' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('image');
        $imagePath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move('uploads/alert_banner', $name);
            $imagePath = 'uploads/alert_banner/' . $name;
        } else {
            return redirect()->back()->withInput()->with('error', 'Invalid image file.');
        }

        $data = [
            'image'       => $imagePath,
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status'      => (int)($this->request->getPost('status') ?? 1),
            'is_popup'    => (int)($this->request->getPost('is_popup') ?? 0),
        ];

        $id = $this->model->insert($data);
        if ($id) {
            log_activity('Created', 'alert_banners', $id);
            return redirect()->to('/admin/alert-banner')->with('success', 'Banner added successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add banner.');
        }
    }

    public function edit($id)
    {
        if (!has_permission('alert_banners.edit')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $data['banner'] = $this->model->find($id);
        if (!$data['banner']) {
            return redirect()->to('/admin/alert-banner')->with('error', 'Banner not found.');
        }
        return view('admin/alert_banner/edit', $data);
    }

    public function update($id)
    {
        if (!has_permission('alert_banners.edit')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $rules = [
            'status'    => 'permit_empty|integer',
            'is_popup'  => 'permit_empty|integer',
            'image'     => 'permit_empty|max_size[image,2048]|is_image[image]',
            'title'     => 'permit_empty|max_length[255]',
            'description' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $banner = $this->model->find($id);
        if (!$banner) {
            return redirect()->to('/admin/alert-banner')->with('error', 'Banner not found.');
        }

        $file = $this->request->getFile('image');
        $imagePath = $banner['image'] ?? null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old image if exists and is a valid file
            if (!empty($banner['image']) && is_file(FCPATH . $banner['image'])) {
                unlink(FCPATH . $banner['image']);
            }
            $name = $file->getRandomName();
            $file->move('uploads/alert_banner', $name);
            $imagePath = 'uploads/alert_banner/' . $name;
        }

        $data = [
            'image'       => $imagePath,
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status'      => (int)($this->request->getPost('status') ?? 1),
            'is_popup'    => (int)($this->request->getPost('is_popup') ?? 0),
        ];

        $updated = $this->model->update($id, $data);
        if ($updated) {
            log_activity('Updated', 'alert_banners', $id);
            return redirect()->to('/admin/alert-banner')->with('success', 'Banner updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update banner.');
        }
    }

    public function delete($id)
    {
        if (!has_permission('alert_banners.delete')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $banner = $this->model->find($id);
        if (!$banner) {
            return redirect()->to('/admin/alert-banner')->with('error', 'Banner not found.');
        }

        // Delete associated image file if exists and is a valid file
        if (!empty($banner['image']) && is_file(FCPATH . $banner['image'])) {
            unlink(FCPATH . $banner['image']);
        }

        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'alert_banners', $id);
            return redirect()->to('/admin/alert-banner')->with('success', 'Banner deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete banner.');
        }
    }
}