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

            $session->set([
                'admin_id' => $admin['id'],
                'admin_email' => $admin['email'],
                'role_id' => $admin['role_id'],
                'isLoggedIn' => true
            ]);

            return redirect()->to('/admin/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}