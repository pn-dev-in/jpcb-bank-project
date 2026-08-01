<?php

namespace App\Controllers\Jbb;

use App\Controllers\BaseController;
use App\Models\JbbUserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session('jbb_logged_in')) {
            return redirect()->to('/jbb/tickets');
        }
        return view('jbb/auth/login');
    }

    public function attempt()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new JbbUserModel();
        $user = $model->authenticate($email, $password);

        if ($user) {
            $model->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

            session()->set([
                'jbb_logged_in' => true,
                'jbb_user_id'   => $user['id'],
                'jbb_user_name' => $user['name'],
                'jbb_user_email'=> $user['email'],
                'jbb_role'      => $user['role'],
            ]);

            return redirect()->to('/jbb/tickets');
        }

        return redirect()->back()->with('error', 'Invalid credentials.');
    }

    public function logout()
    {
        session()->remove(['jbb_logged_in', 'jbb_user_id', 'jbb_user_name', 'jbb_user_email', 'jbb_role']);
        return redirect()->to('/jbb/login')->with('message', 'Logged out.');
    }
}