<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class ProfileController extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $adminId = session()->get('admin_id');
        if (!$adminId) {
            return redirect()->to('/admin/login');
        }

        // Fetch admin with role name
        $admin = $this->adminModel
            ->select('admins.*, roles.name as role_name')
            ->join('roles', 'roles.id = admins.role_id', 'left')
            ->find($adminId);

        if (!$admin) {
            return redirect()->to('/admin/login');
        }

        return view('admin/profile/index', ['admin' => $admin]);
    }

    public function update()
    {
        $adminId = session()->get('admin_id');
        if (!$adminId) {
            return redirect()->to('/admin/login');
        }

        $rules = [
            'name'  => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[150]|is_unique[admins.email,id,' . $adminId . ']',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
        ];

        // Handle password change
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Handle profile image upload
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowed)) {
                return redirect()->back()->withInput()->with('error', 'Only JPG, PNG, GIF, WEBP images are allowed.');
            }
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Image size must be less than 2MB.');
            }

            // Delete old image if exists (full path)
            $oldAdmin = $this->adminModel->find($adminId);
            if (!empty($oldAdmin['profile_image']) && is_file(FCPATH . $oldAdmin['profile_image'])) {
                unlink(FCPATH . $oldAdmin['profile_image']);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile', $newName);
            // Store full relative path from base_url
            $relativePath = 'uploads/profile/' . $newName;
            $data['profile_image'] = $relativePath;
        }

        $this->adminModel->update($adminId, $data);

        // Update session values
        session()->set('admin_name', $data['name']);
        if (isset($data['profile_image'])) {
            session()->set('profile_image', $data['profile_image']);
        }

        log_activity('Updated', 'profile', $adminId);

        return redirect()->to('/admin/profile')->with('success', 'Profile updated successfully.');
    }
}