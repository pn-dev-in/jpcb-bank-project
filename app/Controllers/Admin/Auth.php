<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('admin/login');
    }

    public function loginProcess()
{
    $session = session();
    $model = new AdminModel();

    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $admin = $model->where('email', $email)->first();

    if ($admin && password_verify($password, $admin['password'])) {

        // Fetch role name
        $roleModel = new \App\Models\RoleModel();
        $role = $roleModel->find($admin['role_id']);
        $roleName = $role['name'] ?? 'Unknown Role';

        $session->set([
            'admin_id'    => $admin['id'],
            'admin_email' => $admin['email'],
            'admin_name'  => $admin['name'],
            'employee_id' => $admin['employee_id'] ?? '',
            'role_id'     => $admin['role_id'],
            'role_name'   => $roleName,          // <-- Add this line
            'isLoggedIn'  => true
        ]);

        // Update last login
        $model->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);
        log_activity('Logged In', 'auth', $admin['id']);
        return redirect()->to('/admin/dashboard');
    }

    log_activity('Failed Login', 'auth', null);
    return redirect()->back()->with('error', 'Invalid credentials');
}

    public function logout()
    {   
        $admin_id = session()->get('admin_id');
        if ($admin_id) {
            // Log logout before destroying session
            log_activity('Logged Out', 'auth', $admin_id);
        }
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}