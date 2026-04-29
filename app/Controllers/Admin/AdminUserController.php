<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\RoleModel;

class AdminUserController extends BaseController
{
    protected $model;
    protected $roleModel;

    public function __construct()
    {
        $this->model = new AdminModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        $data['admins'] = $this->model
            ->select('admins.*, roles.name as role_name')
            ->join('roles', 'roles.id = admins.role_id', 'left')
            ->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->roleModel->findAll();
        return view('admin/users/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|max_length[100]',
            'email'    => 'required|valid_email|max_length[150]|is_unique[admins.email]',
            'password' => 'required|min_length[6]',
            'role_id'  => 'required|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id'  => $this->request->getPost('role_id'),
        ];
        $id = $this->model->insert($data);
        if ($id) {
            log_activity('Created', 'admin_users', $id);
            return redirect()->to('/admin/users')->with('success', 'Admin user created successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create admin user.');
        }
    }


    public function edit($id)
    {
        $data['admin'] = $this->model->find($id);
        if (!$data['admin']) {
            return redirect()->to('/admin/users')->with('error', 'Admin not found.');
        }
        $data['roles'] = $this->roleModel->findAll();
        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'  => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[150]|is_unique[admins.email,id,' . $id . ']',
            'role_id' => 'required|integer',
        ];
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role_id' => $this->request->getPost('role_id'),
        ];
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $updated = $this->model->update($id, $data);
        if ($updated) {
            log_activity('Updated', 'admin_users', $id);
            return redirect()->to('/admin/users')->with('success', 'Admin user updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update admin user.');
        }
    }

    public function view($id)
    {
        $admin = $this->model->select('admins.*, roles.name as role_name')
            ->join('roles', 'roles.id = admins.role_id', 'left')
            ->find($id);
        if (!$admin) {
            return redirect()->to('/admin/users')->with('error', 'Admin not found.');
        }
        return view('admin/users/view', ['admin' => $admin]);
    }

    public function delete($id)
    {
        // Prevent deleting your own account
        if ($id == session()->get('admin_id')) {
            return redirect()->to('/admin/users')->with('error', 'You cannot delete your own account.');
        }
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'admin_users', $id);
            return redirect()->to('/admin/users')->with('success', 'Admin user deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete admin user.');
        }
    }
}